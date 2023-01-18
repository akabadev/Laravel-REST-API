import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { IResultLogin } from '@core/models/login.interface';
import { IUser } from '@core/models/user';
import { NgxSpinnerService } from 'ngx-spinner';
import { Observable } from 'rxjs';
import { take, tap } from 'rxjs/operators';
import { environment } from 'src/environments/environment';
import { ForgotPassword } from '../models/forgot-password.interface';
import { ResetPassword } from '../models/reset-Password.interface';
import { TokenService } from './token.service';

const baseUrl = environment.apiUrlOrange;
@Injectable({
  providedIn: 'root',
})
export class AuthService {
  public user: IUser;

  constructor(
    private http: HttpClient,
    private spinner: NgxSpinnerService,
    private tokenService: TokenService
  ) {}

  initializeUser() {
    this.user = this.tokenService.session?.user;
  }

  login(user: { email: string; password: string }): Observable<IResultLogin> {
    return this.http
      .post<IResultLogin>(baseUrl + 'login', {
        email: user.email,
        password: user.password,
      })
      .pipe(
        take(1),
        tap((res) => {
          if (res.success) {
            this.user = res.data.user;
            this.tokenService.setSession(res.data.token, this.user);
          }
        })
      );
  }

  logout() {
    this.tokenService.resetSession();
    this.user = null;
  }

  forgotPassword(body: ForgotPassword) {
    this.spinner.show();
    return this.http
      .post(this.buildURL('account/password/forgot'), body)
      .pipe(take(1));
  }

  resetPassword(body: ResetPassword) {
    this.spinner.show();
    return this.http
      .post(this.buildURL('account/password/update'), body)
      .pipe(take(1));
  }

  buildURL(path: string) {
    return baseUrl + path;
  }
}
