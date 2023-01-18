export interface IRequestResult<T = any> {
  success: boolean;
  message: string;
  data: T;
}
export interface IPutData<T = any> {
  success: boolean;
  message: string;
  data: T;
}
export interface IPostData<T = any> {
  success: boolean;
  message: string;
  data: { data: T };
}
export interface IRequestPagination<T = any> extends IRequestResult {
  data: {
    current_page: number;
    to: number;
    total: number;
    path: string;
    next_page_url: string;
    prev_page_url: string;
    links: {
      url: string;
      active: boolean;
      label: string;
    }[];
    from: number;
    lastPage: number;
    per_page: number;
    data: T[];
  };
}
