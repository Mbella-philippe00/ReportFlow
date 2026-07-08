export type ApiSuccessResponse<TData> = {
    data: TData;
    message?: string;
    success: true;
};

export type ApiMessageResponse = {
    message: string;
    success: true;
};

export type ValidationErrors = Record<string, string[]>;

export type ApiErrorResponse = {
    errors?: ValidationErrors;
    message?: string;
    success?: false;
};

export type PaginationMeta = {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
};

export type PaginatedApiResponse<TData> = {
    data: TData[];
    meta: PaginationMeta;
    success: true;
};
