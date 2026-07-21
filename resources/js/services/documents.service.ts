import { http } from '@/lib/http';
import type {
    ApiMessageResponse,
    ApiSuccessResponse,
    DocumentActivity,
    DocumentComment,
    DocumentFilters,
    PaginatedApiResponse,
    ReportDocument,
    ReportDocumentPreview,
    ReportDocumentVersion,
} from '@/types';

export type DocumentMutationOptions = {
    signal?: AbortSignal;
};

export type UploadDocumentInput = DocumentMutationOptions & {
    category?: string;
    description?: string;
    file: File;
    metadata?: Record<string, unknown>;
    notes?: string;
    reportId: number;
    title?: string;
};

export type UploadDocumentVersionInput = DocumentMutationOptions & {
    documentId: number;
    file: File;
    notes?: string;
    reportId: number;
};

export type UpdateDocumentInput = DocumentMutationOptions & {
    documentId: number;
    payload: Partial<Pick<ReportDocument, 'category' | 'description' | 'metadata' | 'title'>>;
    reportId: number;
};

export type CreateDocumentCommentInput = DocumentMutationOptions & {
    body: string;
    documentId: number;
    mentionIds?: number[];
    parentId?: number | null;
    reportId: number;
};

export type UpdateDocumentCommentInput = DocumentMutationOptions & {
    body: string;
    commentId: number;
    documentId: number;
    mentionIds?: number[];
    reportId: number;
};

const buildDocumentsPath = (reportId: number, params: DocumentFilters = {}) => {
    const searchParams = new URLSearchParams();

    Object.entries(params).forEach(([key, value]) => {
        if (value !== undefined && value !== null && value !== '') {
            searchParams.set(key, String(value));
        }
    });

    const queryString = searchParams.toString();

    return `/reports/${reportId}/documents${queryString ? `?${queryString}` : ''}`;
};

const toDocumentFormData = (input: UploadDocumentInput | UploadDocumentVersionInput) => {
    const formData = new FormData();

    formData.append('file', input.file);

    if ('title' in input && input.title) {
        formData.append('title', input.title);
    }

    if ('description' in input && input.description) {
        formData.append('description', input.description);
    }

    if ('category' in input && input.category) {
        formData.append('category', input.category);
    }

    if (input.notes) {
        formData.append('notes', input.notes);
    }

    if ('metadata' in input && input.metadata) {
        Object.entries(input.metadata).forEach(([key, value]) => {
            formData.append(`metadata[${key}]`, String(value));
        });
    }

    return formData;
};

export const documentQueryKeys = {
    activity: (reportId: number, documentId: number) => ['documents', reportId, documentId, 'activity'] as const,
    all: ['documents'] as const,
    comments: (reportId: number, documentId: number) => ['documents', reportId, documentId, 'comments'] as const,
    list: (reportId: number, params: DocumentFilters = {}) => ['documents', reportId, 'list', params] as const,
    preview: (reportId: number, documentId: number) => ['documents', reportId, documentId, 'preview'] as const,
    versions: (reportId: number, documentId: number) => ['documents', reportId, documentId, 'versions'] as const,
};

export const listReportDocuments = (reportId: number, params: DocumentFilters = {}, { signal }: DocumentMutationOptions = {}) =>
    http<PaginatedApiResponse<ReportDocument>>(buildDocumentsPath(reportId, params), { signal });

export const uploadReportDocument = ({ category, description, file, metadata, notes, reportId, signal, title }: UploadDocumentInput) =>
    http<ApiSuccessResponse<ReportDocument>>(`/reports/${reportId}/documents`, {
        body: toDocumentFormData({ category, description, file, metadata, notes, reportId, title }),
        method: 'POST',
        signal,
    });

export const updateReportDocument = ({ documentId, payload, reportId, signal }: UpdateDocumentInput) =>
    http<ApiSuccessResponse<ReportDocument>>(`/reports/${reportId}/documents/${documentId}`, {
        body: payload,
        method: 'PATCH',
        signal,
    });

export const deleteReportDocument = (reportId: number, documentId: number, { signal }: DocumentMutationOptions = {}) =>
    http<ApiMessageResponse>(`/reports/${reportId}/documents/${documentId}`, {
        method: 'DELETE',
        signal,
    });

export const uploadReportDocumentVersion = ({ documentId, file, notes, reportId, signal }: UploadDocumentVersionInput) =>
    http<ApiSuccessResponse<ReportDocument>>(`/reports/${reportId}/documents/${documentId}/versions`, {
        body: toDocumentFormData({ documentId, file, notes, reportId }),
        method: 'POST',
        signal,
    });

export const previewReportDocument = (reportId: number, documentId: number, { signal }: DocumentMutationOptions = {}) =>
    http<ApiSuccessResponse<ReportDocumentPreview>>(`/reports/${reportId}/documents/${documentId}/preview`, { signal });

export const listDocumentVersions = (reportId: number, documentId: number, { signal }: DocumentMutationOptions = {}) =>
    http<ApiSuccessResponse<ReportDocumentVersion[]>>(`/reports/${reportId}/documents/${documentId}/versions`, { signal });

export const listDocumentComments = (reportId: number, documentId: number, { signal }: DocumentMutationOptions = {}) =>
    http<ApiSuccessResponse<DocumentComment[]>>(`/reports/${reportId}/documents/${documentId}/comments`, { signal });

export const createDocumentComment = ({ body, documentId, mentionIds = [], parentId = null, reportId, signal }: CreateDocumentCommentInput) =>
    http<ApiSuccessResponse<DocumentComment>>(`/reports/${reportId}/documents/${documentId}/comments`, {
        body: { body, mention_ids: mentionIds, parent_id: parentId },
        method: 'POST',
        signal,
    });

export const updateDocumentComment = ({ body, commentId, documentId, mentionIds = [], reportId, signal }: UpdateDocumentCommentInput) =>
    http<ApiSuccessResponse<DocumentComment>>(`/reports/${reportId}/documents/${documentId}/comments/${commentId}`, {
        body: { body, mention_ids: mentionIds },
        method: 'PATCH',
        signal,
    });

export const deleteDocumentComment = (reportId: number, documentId: number, commentId: number, { signal }: DocumentMutationOptions = {}) =>
    http<ApiMessageResponse>(`/reports/${reportId}/documents/${documentId}/comments/${commentId}`, {
        method: 'DELETE',
        signal,
    });

export const listDocumentActivity = (reportId: number, documentId: number, { signal }: DocumentMutationOptions = {}) =>
    http<ApiSuccessResponse<DocumentActivity[]>>(`/reports/${reportId}/documents/${documentId}/activity`, { signal });
