import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { IRequestPagination } from '@core/models/requestResult.model';
import { Paginator } from 'primeng/paginator';
import { Observable } from 'rxjs';
import { take } from 'rxjs/operators';

@Injectable({
  providedIn: 'root',
})
export class PaginatorService {
  constructor(private http: HttpClient) {}

  getDataPagination<T>(url: string): Observable<T> {
    return this.http.get<T>(url).pipe(take(1));
  }
}
