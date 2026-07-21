export type DocumentUser = {
    email: string | null;
    id: number | null;
    name: string | null;
};

export type ReportDocumentVersion = {
    checksum: string | null;
    created_at: string;
    extension: string | null;
    id: number;
    mime_type: string | null;
    notes: string | null;
    original_filename: string;
    size: number;
    updated_at: string;
    uploaded_by: DocumentUser;
    version_number: number;
};

export type ReportDocumentPreview = {
    content?: string;
    filename?: string;
    mime_type?: string | null;
    size?: number;
    supported: boolean;
    type: 'download' | 'image' | 'pdf' | 'text' | string;
    url: string;
};

export type ReportDocument = {
    category: string;
    comments_count: number;
    created_at: string;
    current_version: ReportDocumentVersion | null;
    description: string | null;
    download_url: string;
    id: number;
    metadata: Record<string, unknown>;
    preview: ReportDocumentPreview | null;
    report_id: number;
    title: string;
    updated_at: string;
    uploaded_by: DocumentUser;
    versions_count: number;
};

export type DocumentComment = {
    body: string;
    created_at: string;
    id: number;
    mentions: number[];
    parent_id: number | null;
    replies?: DocumentComment[];
    updated_at: string;
    user: DocumentUser;
};

export type DocumentActivity = {
    causer: DocumentUser;
    created_at: string;
    description: string;
    event: string | null;
    id: number;
    properties: Record<string, unknown>;
};

export type DocumentFilters = {
    category?: string;
    page?: number;
    search?: string;
    sort?: 'latest' | 'oldest' | 'size' | 'title';
    type?: string;
};
