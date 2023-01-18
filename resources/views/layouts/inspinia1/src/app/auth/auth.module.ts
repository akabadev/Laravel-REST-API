import { NgModule } from '@angular/core';
import { NgxSpinnerModule } from 'ngx-spinner';
import { SharedModule } from '../shared/shared.module';
import { AuthRoutingModule } from './auth-routing.module';
import { ForgotPasswordComponent } from './components/forgot-password/forgot-password.component';
import { LoginComponent } from './components/login/login.component';
import { ResetPasswordComponent } from './components/reset-password/reset-password.component';
import { AuthHomeComponent } from './pages/auth-home/auth-home.component';
import { LogoutComponent } from './components/logout/logout.component';

const COMPONENTS = [
  AuthHomeComponent,
  LoginComponent,
  ForgotPasswordComponent,
  ResetPasswordComponent,
];
@NgModule({
  declarations: [COMPONENTS, LogoutComponent],
  imports: [SharedModule, AuthRoutingModule, NgxSpinnerModule],
})
export class AuthModule {}
