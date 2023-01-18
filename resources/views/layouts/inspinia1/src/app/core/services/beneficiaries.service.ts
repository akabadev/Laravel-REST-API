import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { IBeneficiary } from '@core/models/beneficiaries.model';
import {
  IPostData,
  IPutData,
  IRequestPagination,
} from '@core/models/requestResult.model';
import { AtLeast } from '@core/models/utils.model';
import { Observable } from 'rxjs';
import { map, take, tap } from 'rxjs/operators';
import { environment } from 'src/environments/environment';

const baseUrl = environment.apiUrlOrange;
@Injectable({
  providedIn: 'root',
})
export class BeneficiariesService {
  constructor(private http: HttpClient) {}

  getBeneficiaries(): Observable<IRequestPagination<IBeneficiary>> {
    return this.http
      .get<IRequestPagination<IBeneficiary>>(baseUrl + 'views/beneficiaries')
      .pipe(
        take(1),
        tap((e) => e.data.data.forEach((a) => (a.active = !!a.active)))
      );
  }

  createBeneficiary(beneficiary: IBeneficiary): Observable<IBeneficiary> {
    return this.http
      .post<IPostData<IBeneficiary>>(
        baseUrl + 'views/beneficiaries',
        beneficiary
      )
      .pipe(
        take(1),
        map((res) => res.data?.data)
      );
  }

  updateBeneficiary(
    beneficiary: AtLeast<IBeneficiary, 'id'>
  ): Observable<IBeneficiary> {
    const { id, ...toUpdate } = beneficiary;
    return this.http
      .put<IPutData<IBeneficiary>>(
        baseUrl + `views/beneficiaries/` + id,
        toUpdate
      )
      .pipe(
        take(1),
        map((res) => res.data)
      );
  }

  deleteBeneficiary(id: string | number) {
    return this.http
      .delete(baseUrl + `views/beneficiaries/` + id)
      .pipe(take(1));
  }
}
