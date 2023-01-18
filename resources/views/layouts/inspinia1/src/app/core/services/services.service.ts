import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { IGetServices } from '@core/models/service.model';
import { Observable } from 'rxjs';
import { shareReplay, take } from 'rxjs/operators';
import { environment } from 'src/environments/environment';

const baseUrl = environment.apiUrlOrange;
@Injectable({
  providedIn: 'root',
})
export class ServicesService {
  private httpGetAll = this.http
    .get<IGetServices>(baseUrl + 'services')
    .pipe(take(1), shareReplay(1));

  constructor(private http: HttpClient) {}

  getServices(): Observable<IGetServices> {
    return this.httpGetAll;
  }
}
