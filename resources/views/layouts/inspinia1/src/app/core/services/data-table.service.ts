import { HttpClient, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { take } from 'rxjs/operators';

@Injectable({
  providedIn: 'root',
})
export class DataTableService {
  constructor(private http: HttpClient) {}

  getDataFromUrl<T>(url: string, params: HttpParams): Observable<T> {
    return this.http.get<T>(url, { params }).pipe(take(1));
  }
}
