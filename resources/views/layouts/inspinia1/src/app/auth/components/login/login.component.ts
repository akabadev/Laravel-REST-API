import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { TYPE_ALERT } from '@core/models/values.config';
import { ToastrService } from '@core/services/utils/toastr.service';
import { AuthService } from 'src/app/core/services/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit {
  constructor(
    public router: Router,
    public authService: AuthService,
    private toastrService: ToastrService
  ) {}

  public form: FormGroup = new FormBuilder().group({
    email: ['', [Validators.required, Validators.email]],
    password: ['', [Validators.required]],
  });

  ngOnInit() {
    if (this.loggedIn) {
      this.router.navigate(['home-page']);
    }
  }

  onSubmit() {
    if (this.form.valid) {
      this.authService.login(this.form.value).subscribe((result) => {
        if (result.success) {
          const msg = '<span class="msgOk">CONNEXION REUSSIE</span>';
          this.toastrService.notify(TYPE_ALERT.SUCCESS, msg);
          this.router.navigate(['/home']);
        }
      });
    }
  }

  loggedIn() {
    const token = localStorage.getItem('session');
    return !!token;
  }
}
