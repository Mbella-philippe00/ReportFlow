import {
    Clock3,
    Download,
    File,
    FileArchive,
    FileText,
    History,
    MessageSquare,
    Search,
    Send,
    UploadCloud,
} from 'lucide-react';
import { useMemo, useRef, useState } from 'react';
import type { ChangeEvent, DragEvent } from 'react';

import { DataToolbar } from '@/components/business/common/DataToolbar';
import { Badge, Button, Card, CardContent, CardDescription, CardHeader, CardTitle, EmptyState, Input, Select, Skeleton, Textarea } from '@/components/ui';
import {
    useCreateDocumentCommentMutation,
    useDeleteReportDocumentMutation,
    useDocumentActivityQuery,
    useDocumentCommentsQuery,
    useDocumentPreviewQuery,
    useDocumentVersionsQuery,
    useReportDocumentsQuery,
    useUploadReportDocumentMutation,
    useUploadReportDocumentVersionMutation,
} from '@/features/documents/hooks/useReportDocuments';
import { useToast } from '@/providers/ToastProvider';
import type { DocumentComment, DocumentFilters, ReportDocument, WeeklyReport } from '@/types';
import { cn } from '@/utils/cn';

const categoryOptions = [
    { label: 'All categories', value: '' },
    { label: 'General', value: 'general' },
    { label: 'Evidence', value: 'evidence' },
    { label: 'Metrics', value: 'metrics' },
    { label: 'Planning', value: 'planning' },
    { label: 'Review', value: 'review' },
] as const;

const typeOptions = [
    { label: 'All file types', value: '' },
    { label: 'Images', value: 'image' },
    { label: 'PDFs', value: 'pdf' },
    { label: 'Text files', value: 'text' },
    { label: 'Word', value: 'docx' },
    { label: 'Excel', value: 'xlsx' },
] as const;

const sortOptions = [
    { label: 'Newest first', value: 'latest' },
    { label: 'Oldest first', value: 'oldest' },
    { label: 'Title', value: 'title' },
    { label: 'Largest file', value: 'size' },
] as const;

const getErrorMessage = (error: unknown): string => (error instanceof Error ? error.message : 'The document action failed.');

const formatBytes = (size?: number | null): string => {
    if (!size) {
        return '0 B';
    }

    const units = ['B', 'KB', 'MB', 'GB'];
    const exponent = Math.min(Math.floor(Math.log(size) / Math.log(1024)), units.length - 1);

    return `${(size / 1024 ** exponent).toFixed(exponent === 0 ? 0 : 1)} ${units[exponent]}`;
};

const formatDate = (value: string | null | undefined): string => {
    if (!value) {
        return 'Not available';
    }

    return new Intl.DateTimeFormat(undefined, {
        dateStyle: 'medium',
        timeStyle: 'short',
    }).format(new Date(value));
};

function CommentThread({ comments }: { comments: DocumentComment[] }) {
    if (comments.length === 0) {
        return <p className="rounded-xl bg-muted/50 p-3 text-sm text-muted-foreground">No comments yet. Start the document thread below.</p>;
    }

    return (
        <div className="grid gap-3">
            {comments.map((comment) => (
                <article className="rounded-xl border bg-background p-3" key={comment.id}>
                    <div className="flex flex-wrap items-center justify-between gap-2">
                        <p className="text-sm font-medium text-foreground">{comment.user.name ?? 'Unknown teammate'}</p>
                        <p className="text-xs text-muted-foreground">{formatDate(comment.created_at)}</p>
                    </div>
                    <p className="mt-2 whitespace-pre-line text-sm leading-6 text-muted-foreground">{comment.body}</p>
                    {comment.replies && comment.replies.length > 0 && (
                        <div className="mt-3 border-l pl-3">
                            <CommentThread comments={comment.replies} />
                        </div>
                    )}
                </article>
            ))}
        </div>
    );
}

function DocumentPreview({ document, reportId }: { document: ReportDocument; reportId: number }) {
    const previewQuery = useDocumentPreviewQuery(reportId, document.id);
    const preview = previewQuery.data?.data ?? document.preview;

    if (previewQuery.isLoading) {
        return <Skeleton className="h-48" />;
    }

    if (!preview || !preview.supported) {
        return (
            <div className="rounded-xl border border-dashed p-4 text-center">
                <FileArchive aria-hidden="true" className="mx-auto size-8 text-muted-foreground" />
                <p className="mt-2 text-sm font-medium text-foreground">Preview unavailable</p>
                <p className="mt-1 text-sm text-muted-foreground">Download the file to open it locally.</p>
                {document.preview?.url && (
                    <a className="mt-3 inline-flex text-sm font-medium text-primary hover:underline" href={document.preview.url} rel="noreferrer" target="_blank">
                        Download file
                    </a>
                )}
            </div>
        );
    }

    if (preview.type === 'image') {
        return <img alt={document.title} className="max-h-80 w-full rounded-xl border object-contain" src={preview.url} />;
    }

    if (preview.type === 'pdf') {
        return <iframe className="h-80 w-full rounded-xl border" src={preview.url} title={`${document.title} preview`} />;
    }

    if (preview.type === 'text') {
        return <pre className="max-h-80 overflow-auto rounded-xl border bg-muted/50 p-4 text-xs leading-6 text-foreground">{preview.content ?? 'Text preview unavailable.'}</pre>;
    }

    return null;
}

export function ReportDocumentsPanel({ report }: { report: WeeklyReport }) {
    const { notify } = useToast();
    const fileInputRef = useRef<HTMLInputElement>(null);
    const versionInputRef = useRef<HTMLInputElement>(null);
    const [filters, setFilters] = useState<DocumentFilters>({ sort: 'latest' });
    const [isDragging, setIsDragging] = useState(false);
    const [selectedDocumentId, setSelectedDocumentId] = useState<number | null>(null);
    const [commentBody, setCommentBody] = useState('');
    const [uploadCategory, setUploadCategory] = useState('general');

    const documentsQuery = useReportDocumentsQuery(report.id, filters);
    const uploadDocument = useUploadReportDocumentMutation();
    const deleteDocument = useDeleteReportDocumentMutation();
    const uploadVersion = useUploadReportDocumentVersionMutation();
    const createComment = useCreateDocumentCommentMutation();

    const documents = documentsQuery.data?.data ?? [];
    const selectedDocument = useMemo(
        () => documents.find((document) => document.id === selectedDocumentId) ?? documents[0] ?? null,
        [documents, selectedDocumentId],
    );

    const versionsQuery = useDocumentVersionsQuery(report.id, selectedDocument?.id ?? null);
    const commentsQuery = useDocumentCommentsQuery(report.id, selectedDocument?.id ?? null);
    const activityQuery = useDocumentActivityQuery(report.id, selectedDocument?.id ?? null);

    const handleFilterChange = (key: keyof DocumentFilters, value: string) => {
        setFilters((current) => ({
            ...current,
            [key]: value || undefined,
            page: undefined,
        }));
    };

    const handleFileUpload = (file: File | undefined) => {
        if (!file) {
            return;
        }

        uploadDocument.mutate(
            {
                category: uploadCategory,
                file,
                notes: 'Uploaded from the report document panel.',
                reportId: report.id,
                title: file.name.replace(/\.[^/.]+$/, ''),
            },
            {
                onSuccess: (response) => {
                    notify({ intent: 'success', title: 'Document uploaded', description: `${response.data.title} is now attached to this report.` });
                    setSelectedDocumentId(response.data.id);
                },
                onError: (error) => {
                    notify({ intent: 'error', title: 'Upload failed', description: getErrorMessage(error) });
                },
            },
        );
    };

    const handleDrop = (event: DragEvent<HTMLDivElement>) => {
        event.preventDefault();
        setIsDragging(false);
        handleFileUpload(event.dataTransfer.files?.[0]);
    };

    const handleVersionUpload = (file: File | undefined) => {
        if (!file || !selectedDocument) {
            return;
        }

        uploadVersion.mutate(
            {
                documentId: selectedDocument.id,
                file,
                notes: 'Version uploaded from the report document panel.',
                reportId: report.id,
            },
            {
                onSuccess: () => {
                    notify({ intent: 'success', title: 'Version uploaded', description: 'The document history has been updated.' });
                },
                onError: (error) => {
                    notify({ intent: 'error', title: 'Version upload failed', description: getErrorMessage(error) });
                },
            },
        );
    };

    const handleCommentSubmit = () => {
        if (!selectedDocument || commentBody.trim().length === 0) {
            return;
        }

        createComment.mutate(
            {
                body: commentBody.trim(),
                documentId: selectedDocument.id,
                reportId: report.id,
            },
            {
                onSuccess: () => {
                    setCommentBody('');
                    notify({ intent: 'success', title: 'Comment added', description: 'The document thread was updated.' });
                },
                onError: (error) => {
                    notify({ intent: 'error', title: 'Comment failed', description: getErrorMessage(error) });
                },
            },
        );
    };

    const handleDelete = (document: ReportDocument) => {
        deleteDocument.mutate(
            { documentId: document.id, reportId: report.id },
            {
                onSuccess: () => {
                    notify({ intent: 'success', title: 'Document deleted', description: `${document.title} was removed.` });
                    setSelectedDocumentId(null);
                },
                onError: (error) => {
                    notify({ intent: 'error', title: 'Delete failed', description: getErrorMessage(error) });
                },
            },
        );
    };

    return (
        <Card>
            <CardHeader>
                <CardTitle>Documents & collaboration</CardTitle>
                <CardDescription>Attach supporting files, preview content, track versions, and collaborate with threaded comments.</CardDescription>
            </CardHeader>
            <CardContent className="grid gap-5">
                <div
                    className={cn(
                        'rounded-2xl border border-dashed bg-muted/30 p-5 text-center transition',
                        isDragging && 'border-primary bg-primary/5',
                    )}
                    onDragLeave={() => setIsDragging(false)}
                    onDragOver={(event) => {
                        event.preventDefault();
                        setIsDragging(true);
                    }}
                    onDrop={handleDrop}
                >
                    <UploadCloud aria-hidden="true" className="mx-auto size-9 text-primary" />
                    <p className="mt-2 text-sm font-medium text-foreground">Drop files here to attach them to this report</p>
                    <p className="mt-1 text-xs text-muted-foreground">Supports previews for images, PDFs, and text files. Maximum upload: 20 MB.</p>
                    <div className="mt-4 flex flex-col items-center justify-center gap-3 sm:flex-row">
                        <Select
                            aria-label="Upload category"
                            className="w-44"
                            onChange={(event) => setUploadCategory(event.target.value)}
                            options={categoryOptions.filter((option) => option.value)}
                            value={uploadCategory}
                        />
                        <Button loading={uploadDocument.isPending} onClick={() => fileInputRef.current?.click()} variant="outline">
                            Choose file
                        </Button>
                        <input
                            className="sr-only"
                            onChange={(event: ChangeEvent<HTMLInputElement>) => handleFileUpload(event.currentTarget.files?.[0])}
                            ref={fileInputRef}
                            type="file"
                        />
                    </div>
                </div>

                <DataToolbar
                    filters={
                        <>
                            <Select
                                aria-label="Filter attachments by category"
                                onChange={(event) => handleFilterChange('category', event.target.value)}
                                options={categoryOptions}
                                value={filters.category ?? ''}
                            />
                            <Select
                                aria-label="Filter attachments by file type"
                                onChange={(event) => handleFilterChange('type', event.target.value)}
                                options={typeOptions}
                                value={filters.type ?? ''}
                            />
                            <Select
                                aria-label="Sort attachments"
                                onChange={(event) => handleFilterChange('sort', event.target.value)}
                                options={sortOptions}
                                value={filters.sort ?? 'latest'}
                            />
                        </>
                    }
                    search={
                        <Input
                            aria-label="Search attachments"
                            leftIcon={<Search aria-hidden="true" className="size-4" />}
                            onChange={(event) => handleFilterChange('search', event.target.value)}
                            placeholder="Search files, notes, or metadata"
                            value={filters.search ?? ''}
                        />
                    }
                />

                {documentsQuery.isLoading ? (
                    <div className="grid gap-3">
                        <Skeleton className="h-24" />
                        <Skeleton className="h-24" />
                    </div>
                ) : documents.length === 0 ? (
                    <EmptyState
                        icon={<FileText aria-hidden="true" className="size-10" />}
                        title="No attachments yet"
                        description="Upload a file to start the document timeline for this report."
                    />
                ) : (
                    <div className="grid gap-4 xl:grid-cols-[minmax(0,0.85fr)_minmax(0,1.15fr)]">
                        <div className="grid content-start gap-3">
                            {documents.map((document) => (
                                <button
                                    className={cn(
                                        'rounded-2xl border bg-background p-4 text-left transition hover:border-primary/50 hover:bg-primary/5',
                                        selectedDocument?.id === document.id && 'border-primary bg-primary/5',
                                    )}
                                    key={document.id}
                                    onClick={() => setSelectedDocumentId(document.id)}
                                    type="button"
                                >
                                    <div className="flex items-start justify-between gap-3">
                                        <div className="min-w-0">
                                            <p className="truncate text-sm font-semibold text-foreground">{document.title}</p>
                                            <p className="mt-1 truncate text-xs text-muted-foreground">{document.current_version?.original_filename}</p>
                                        </div>
                                        <Badge intent="primary">{document.category}</Badge>
                                    </div>
                                    <div className="mt-3 flex flex-wrap gap-2 text-xs text-muted-foreground">
                                        <span>{formatBytes(document.current_version?.size)}</span>
                                        <span>{document.versions_count} version{document.versions_count === 1 ? '' : 's'}</span>
                                        <span>{document.comments_count} comment{document.comments_count === 1 ? '' : 's'}</span>
                                    </div>
                                </button>
                            ))}
                        </div>

                        {selectedDocument && (
                            <section className="grid gap-4 rounded-2xl border bg-background p-4">
                                <div className="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                    <div>
                                        <h3 className="text-base font-semibold text-foreground">{selectedDocument.title}</h3>
                                        <p className="mt-1 text-sm text-muted-foreground">{selectedDocument.description ?? 'No description provided.'}</p>
                                    </div>
                                    <div className="flex flex-wrap gap-2">
                                        {selectedDocument.preview?.url && (
                                            <a className="inline-flex h-9 items-center gap-2 rounded-xl border px-3 text-sm font-medium hover:bg-muted" href={selectedDocument.preview.url} rel="noreferrer" target="_blank">
                                                <Download aria-hidden="true" className="size-4" />
                                                Open
                                            </a>
                                        )}
                                        <Button loading={deleteDocument.isPending} onClick={() => handleDelete(selectedDocument)} size="sm" variant="danger">
                                            Delete
                                        </Button>
                                    </div>
                                </div>

                                <DocumentPreview document={selectedDocument} reportId={report.id} />

                                <div className="grid gap-4 lg:grid-cols-2">
                                    <section className="rounded-2xl border p-4">
                                        <h4 className="flex items-center gap-2 text-sm font-semibold text-foreground">
                                            <File aria-hidden="true" className="size-4" />
                                            Metadata
                                        </h4>
                                        <dl className="mt-3 grid gap-2 text-sm">
                                            <div className="flex justify-between gap-3">
                                                <dt className="text-muted-foreground">Uploaded by</dt>
                                                <dd className="text-right font-medium">{selectedDocument.uploaded_by.name ?? 'Unknown'}</dd>
                                            </div>
                                            <div className="flex justify-between gap-3">
                                                <dt className="text-muted-foreground">MIME type</dt>
                                                <dd className="text-right font-medium">{selectedDocument.current_version?.mime_type ?? 'Unknown'}</dd>
                                            </div>
                                            <div className="flex justify-between gap-3">
                                                <dt className="text-muted-foreground">Checksum</dt>
                                                <dd className="max-w-40 truncate text-right font-mono text-xs">{selectedDocument.current_version?.checksum ?? '—'}</dd>
                                            </div>
                                            <div className="flex justify-between gap-3">
                                                <dt className="text-muted-foreground">Updated</dt>
                                                <dd className="text-right font-medium">{formatDate(selectedDocument.updated_at)}</dd>
                                            </div>
                                        </dl>
                                    </section>

                                    <section className="rounded-2xl border p-4">
                                        <h4 className="flex items-center gap-2 text-sm font-semibold text-foreground">
                                            <History aria-hidden="true" className="size-4" />
                                            Version history
                                        </h4>
                                        <div className="mt-3 grid gap-2">
                                            {versionsQuery.isLoading ? (
                                                <Skeleton className="h-20" />
                                            ) : (
                                                versionsQuery.data?.data.map((version) => (
                                                    <div className="rounded-xl bg-muted/50 p-3 text-sm" key={version.id}>
                                                        <div className="flex items-center justify-between gap-2">
                                                            <span className="font-medium">v{version.version_number} · {version.original_filename}</span>
                                                            <span className="text-xs text-muted-foreground">{formatBytes(version.size)}</span>
                                                        </div>
                                                        <p className="mt-1 text-xs text-muted-foreground">{version.notes ?? 'No version notes.'}</p>
                                                    </div>
                                                ))
                                            )}
                                            <Button loading={uploadVersion.isPending} onClick={() => versionInputRef.current?.click()} size="sm" variant="outline">
                                                Upload new version
                                            </Button>
                                            <input
                                                className="sr-only"
                                                onChange={(event: ChangeEvent<HTMLInputElement>) => handleVersionUpload(event.currentTarget.files?.[0])}
                                                ref={versionInputRef}
                                                type="file"
                                            />
                                        </div>
                                    </section>
                                </div>

                                <section className="rounded-2xl border p-4">
                                    <h4 className="flex items-center gap-2 text-sm font-semibold text-foreground">
                                        <MessageSquare aria-hidden="true" className="size-4" />
                                        Threaded comments
                                    </h4>
                                    <div className="mt-3">
                                        {commentsQuery.isLoading ? <Skeleton className="h-28" /> : <CommentThread comments={commentsQuery.data?.data ?? []} />}
                                    </div>
                                    <div className="mt-3 grid gap-2">
                                        <Textarea
                                            aria-label="Add document comment"
                                            helperText="Mention teammates by email, for example @manager@example.com."
                                            onChange={(event) => setCommentBody(event.target.value)}
                                            placeholder="Add a comment or mention a teammate…"
                                            value={commentBody}
                                        />
                                        <Button className="justify-self-end" loading={createComment.isPending} onClick={handleCommentSubmit} rightIcon={<Send aria-hidden="true" className="size-4" />}>
                                            Comment
                                        </Button>
                                    </div>
                                </section>

                                <section className="rounded-2xl border p-4">
                                    <h4 className="flex items-center gap-2 text-sm font-semibold text-foreground">
                                        <Clock3 aria-hidden="true" className="size-4" />
                                        Document activity
                                    </h4>
                                    <div className="mt-3 grid gap-2">
                                        {activityQuery.isLoading ? (
                                            <Skeleton className="h-20" />
                                        ) : (activityQuery.data?.data.length ?? 0) === 0 ? (
                                            <p className="text-sm text-muted-foreground">No activity has been recorded yet.</p>
                                        ) : (
                                            activityQuery.data?.data.map((activity) => (
                                                <div className="rounded-xl bg-muted/50 p-3 text-sm" key={activity.id}>
                                                    <div className="flex flex-wrap items-center justify-between gap-2">
                                                        <span className="font-medium">{activity.description}</span>
                                                        <span className="text-xs text-muted-foreground">{formatDate(activity.created_at)}</span>
                                                    </div>
                                                    <p className="mt-1 text-xs text-muted-foreground">{activity.causer.name ?? 'System activity'}</p>
                                                </div>
                                            ))
                                        )}
                                    </div>
                                </section>
                            </section>
                        )}
                    </div>
                )}
            </CardContent>
        </Card>
    );
}
