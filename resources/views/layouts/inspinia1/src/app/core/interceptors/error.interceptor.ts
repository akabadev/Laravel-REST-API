import {
  HttpErrorResponse,
  HttpEvent,
  HttpHandler,
  HttpHeaders,
  HttpInterceptor,
  HttpRequest,
} from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Router } from '@angular/router';
import { TokenService } from '@core/services/token.service';
import { ToastrService } from '@core/services/utils/toastr.service';
import { NgxSpinnerService } from 'ngx-spinner';
import { Observable, throwError } from 'rxjs';
import { catchError, finalize } from 'rxjs/operators';
import { environment } from 'src/environments/environment';
import { TYPE_ALERT } from '../models/values.config';

@Injectable()
export class ErrorInterceptor implements HttpInterceptor {
  errorMessage: string;
  isLoginFailed: boolean;

  constructor(
    private spinner: NgxSpinnerService,
    private toastrService: ToastrService,
    private tokenService: TokenService,
    private router: Router
  ) {}

  intercept(
    req: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    this.spinner.show();
    let headers = new HttpHeaders().append('Content-Type', 'application/json');
    if (req.url.includes(environment.apiUrlOrange)) {
      headers = headers.append(
        'Authorization',
        'Bearer ' + this.tokenService.session?.token
      );
    }
    const clone = req.clone({
      headers,
    });

    return next.handle(clone).pipe(
      finalize(() => {
        this.spinner.hide();
      }),
      catchError((error) => {
        this.spinner.hide();
        if (error instanceof HttpErrorResponse) {
          const applicationError = error.headers.get('Application-Error');
          //TODO à retirer quand refresh de Token
          if (!error.url.includes('login') && error.status === 401) {
            this.tokenService.resetSession();
            this.router.navigateByUrl('/auth/login');
          }
          if (applicationError) {
            return throwError(applicationError);
          } else {
            this.spinner.hide();
            const msg =
              '<span class="msgOk">UNE ERREUR EST SURVENUE, VEUILLEZ CONTACTER L\'ADMINISTRATEUR</span>';
            this.toastrService.notify(TYPE_ALERT.ERROR, msg);
            this.isLoginFailed = true;
          }
        }
        return throwError(this.errorMessage);
      })
    );
  }
}
