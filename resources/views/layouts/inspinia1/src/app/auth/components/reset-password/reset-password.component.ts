import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { TYPE_ALERT } from '@core/models/values.config';
import { ToastrService } from '@core/services/utils/toastr.service';
import { NgxSpinnerService } from 'ngx-spinner';
import { throwError } from 'rxjs';
import { AuthService } from 'src/app/core/services/auth.service';
import { MustMatch } from '@shared/validators/mustMatchPassword';

@Component({
  selector: 'app-reset-password',
  templateUrl: './reset-password.component.html',
  styleUrls: ['./reset-password.component.css'],
})
export class ResetPasswordComponent implements OnInit {
  changePasswordForm: FormGroup;
  errors = null;
  IsvalidForm = true;
  successMsg = null;
  submitted = false;

  constructor(
    public fb: FormBuilder,
    public route: ActivatedRoute,
    public authService: AuthService,
    public router: Router,
    public spinner: NgxSpinnerService,
    private toastrService: ToastrService
  ) {}

  ngOnInit() {
    this.changePasswordForm = this.fb.group(
      {
        password: ['', [Validators.required, Validators.minLength(8)]],
        password_confirmation: ['', Validators.required],
      },
      {
        validator: MustMatch('password', 'password_confirmation'),
      }
    );
  }

  get f() {
    return this.changePasswordForm.controls;
  }

  onSubmit() {
    this.submitted = true;

    // stop here if form is invalid
    if (this.changePasswordForm.invalid) {
      return;
    }
    this.authService.resetPassword(this.changePasswordForm.value).subscribe(
      (result) => {
        const msg =
          '<span class="msgOk">VOTRE MOT DE PASSE À ÉTÉ MIS À JOUR</span>';
        this.toastrService.notify(TYPE_ALERT.SUCCESS, msg);
        this.successMsg = result;
        this.changePasswordForm.reset();
        this.router.navigate(['login']);
        this.spinner.hide();
      },
      (error) => {
        this.handleError(error);
      }
    );
  }

  handleError(error) {
    this.IsvalidForm = true;
    let errorMessage = '';
    if (error.error instanceof ErrorEvent) {
      // client-side error
      errorMessage = `Error: ${error.error.message}`;
    } else {
      const msg =
        '<span class="msgOk">UNE ERREUR EST SURVENU LORS DE VOTRE SAISIE</span>';
      this.toastrService.notify(TYPE_ALERT.ERROR, msg);
      errorMessage = `Error Code: ${error.status}\nMessage: ${error.message}`;
      this.IsvalidForm = false;
      this.spinner.hide();
    }
    return throwError(errorMessage);
  }

  onReset() {
    this.submitted = false;
    this.changePasswordForm.reset();
  }
}
