import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';

import { analyticsQueryKeys } from '@/services/analytics.service';
import {
    createDocumentComment,
    deleteReportDocument,
    documentQueryKeys,
    listDocumentActivity,
    listDocumentComments,
    listDocumentVersions,
    listReportDocuments,
    previewReportDocument,
    updateReportDocument,
    uploadReportDocument,
    uploadReportDocumentVersion,
} from '@/services/documents.service';
import { reportsQueryKeys } from '@/services/reports.service';
import type { CreateDocumentCommentInput, UpdateDocumentInput, UploadDocumentInput, UploadDocumentVersionInput } from '@/services/documents.service';
import type { DocumentFilters } from '@/types';

export const useReportDocumentsQuery = (reportId: number, filters: DocumentFilters = {}) =>
    useQuery({
        enabled: Number.isFinite(reportId) && reportId > 0,
        queryFn: ({ signal }) => listReportDocuments(reportId, filters, { signal }),
        queryKey: documentQueryKeys.list(reportId, filters),
    });

export const useDocumentPreviewQuery = (reportId: number, documentId: number | null) =>
    useQuery({
        enabled: Number.isFinite(reportId) && Boolean(documentId),
        queryFn: ({ signal }) => previewReportDocument(reportId, documentId as number, { signal }),
        queryKey: documentId ? documentQueryKeys.preview(reportId, documentId) : ['documents', reportId, 'preview', 'none'],
    });

export const useDocumentVersionsQuery = (reportId: number, documentId: number | null) =>
    useQuery({
        enabled: Number.isFinite(reportId) && Boolean(documentId),
        queryFn: ({ signal }) => listDocumentVersions(reportId, documentId as number, { signal }),
        queryKey: documentId ? documentQueryKeys.versions(reportId, documentId) : ['documents', reportId, 'versions', 'none'],
    });

export const useDocumentCommentsQuery = (reportId: number, documentId: number | null) =>
    useQuery({
        enabled: Number.isFinite(reportId) && Boolean(documentId),
        queryFn: ({ signal }) => listDocumentComments(reportId, documentId as number, { signal }),
        queryKey: documentId ? documentQueryKeys.comments(reportId, documentId) : ['documents', reportId, 'comments', 'none'],
    });

export const useDocumentActivityQuery = (reportId: number, documentId: number | null) =>
    useQuery({
        enabled: Number.isFinite(reportId) && Boolean(documentId),
        queryFn: ({ signal }) => listDocumentActivity(reportId, documentId as number, { signal }),
        queryKey: documentId ? documentQueryKeys.activity(reportId, documentId) : ['documents', reportId, 'activity', 'none'],
    });

const invalidateDocumentData = (queryClient: ReturnType<typeof useQueryClient>, reportId: number, documentId?: number) => {
    void queryClient.invalidateQueries({ queryKey: documentQueryKeys.all });
    void queryClient.invalidateQueries({ queryKey: reportsQueryKeys.detail(reportId) });
    void queryClient.invalidateQueries({ queryKey: analyticsQueryKeys.all });

    if (documentId) {
        void queryClient.invalidateQueries({ queryKey: documentQueryKeys.comments(reportId, documentId) });
        void queryClient.invalidateQueries({ queryKey: documentQueryKeys.versions(reportId, documentId) });
        void queryClient.invalidateQueries({ queryKey: documentQueryKeys.activity(reportId, documentId) });
    }
};

export const useUploadReportDocumentMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (input: UploadDocumentInput) => uploadReportDocument(input),
        onSuccess: (response, input) => {
            invalidateDocumentData(queryClient, input.reportId, response.data.id);
        },
    });
};

export const useUpdateReportDocumentMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (input: UpdateDocumentInput) => updateReportDocument(input),
        onSuccess: (response, input) => {
            invalidateDocumentData(queryClient, input.reportId, response.data.id);
        },
    });
};

export const useDeleteReportDocumentMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: ({ documentId, reportId }: { documentId: number; reportId: number }) => deleteReportDocument(reportId, documentId),
        onSuccess: (_response, input) => {
            invalidateDocumentData(queryClient, input.reportId, input.documentId);
        },
    });
};

export const useUploadReportDocumentVersionMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (input: UploadDocumentVersionInput) => uploadReportDocumentVersion(input),
        onSuccess: (response, input) => {
            invalidateDocumentData(queryClient, input.reportId, response.data.id);
        },
    });
};

export const useCreateDocumentCommentMutation = () => {
    const queryClient = useQueryClient();

    return useMutation({
        mutationFn: (input: CreateDocumentCommentInput) => createDocumentComment(input),
        onSuccess: (_response, input) => {
            invalidateDocumentData(queryClient, input.reportId, input.documentId);
        },
    });
};
