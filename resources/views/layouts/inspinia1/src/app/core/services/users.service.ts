import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { IPostData, IPutData, IRequestPagination } from '@core/models/requestResult.model';
import { IUser } from '@core/models/user';
import { Observable } from 'rxjs';
import { map, take } from 'rxjs/operators';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})
export class UserService {
  baseUrl = environment.apiUrlOrange;

  constructor(private http: HttpClient) {}

  getUsers() {
    return this.http.get<IRequestPagination<IUser>>(this.baseUrl + 'users').pipe(take(1));
  }

  createUser(user: IUser): Observable<IUser> {
    return this.http.post<IPostData<IUser>>(this.baseUrl + 'users', user).pipe(
      take(1),
      map((res) => res.data?.data)
    );
  }

  updateUser(user: IUser): Observable<IUser> {
    const { id, ...toUpdate } = user;
    return this.http.put<IPutData<IUser>>(this.baseUrl + `users/` + id, toUpdate).pipe(
      take(1),
      map((res) => res.data)
    );
  }

  getUserById(id: string | number) {
    return this.http.get(this.baseUrl + `users/` + id).pipe(take(1));
  }

  deleteUser(id: string | number) {
    return this.http.delete(this.baseUrl + `users/` + id).pipe(take(1));
  }
}
