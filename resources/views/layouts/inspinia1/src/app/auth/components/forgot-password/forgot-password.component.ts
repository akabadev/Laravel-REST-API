import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { TYPE_ALERT } from '@core/models/values.config';
import { ToastrService } from '@core/services/utils/toastr.service';
import { NgxSpinnerService } from 'ngx-spinner';
import { AuthService } from 'src/app/core/services/auth.service';

@Component({
  selector: 'app-forgot-password',
  templateUrl: './forgot-password.component.html',
  styleUrls: ['./forgot-password.component.scss'],
})
export class ForgotPasswordComponent implements OnInit {
  resetForm: FormGroup;

  constructor(
    public fb: FormBuilder,
    public authService: AuthService,
    public spinner: NgxSpinnerService,
    private toastrService: ToastrService
  ) {}

  ngOnInit() {
    this.resetForm = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
    });
  }

  get f() {
    return this.resetForm.controls;
  }

  showSpinner() {
    setTimeout(() => {
      this.spinner.hide();
    }, 2000);
  }

  requestForgotPassword() {
    this.resetForm.markAllAsTouched();
    if (this.resetForm.valid) {
      this.authService.forgotPassword(this.resetForm.value).subscribe(
        () => {
          const msg =
            '<span class="msgOk">UN LIEN VOUS À ÉTÉ ENVOYÉ SUR VOTRE BOITE MAIL</span>';
          this.toastrService.notify(TYPE_ALERT.SUCCESS, msg);
          this.spinner.hide();
        },
        (err) => {
          this.spinner.hide();
        }
      );
    }
  }
}
