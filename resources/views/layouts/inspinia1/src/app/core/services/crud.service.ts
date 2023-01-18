import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import {
  IPostData,
  IPutData,
  IRequestPagination
} from '@core/models/requestResult.model';
import { Observable } from 'rxjs';
import { map, take } from 'rxjs/operators';

@Injectable({
  providedIn: 'root',
})
export class CrudService {
  constructor(private http: HttpClient) {}

  get<T extends { id: string } = any>(
    url: string
  ): Observable<IRequestPagination<T>> {
    return this.http.get<IRequestPagination<T>>(url).pipe(take(1));
  }

  create<T extends { id: string } = any>(
    url: string,
    element: T
  ): Observable<T> {
    return this.http.post<IPostData<T>>(url, element).pipe(
      take(1),
      map((res) => res.data?.data)
    );
  }

  update<T extends { id: string } = any>(
    url: string,
    { id, ...toUpdate }: T
  ): Observable<T> {
    return this.http.put<IPutData<T>>(url + '/' + id, toUpdate).pipe(
      take(1),
      map((res) => res.data)
    );
  }

  delete<T extends { id: string } = any>(url: string, id: string | number) {
    return this.http.delete(url + '/' + id).pipe(take(1));
  }
}
