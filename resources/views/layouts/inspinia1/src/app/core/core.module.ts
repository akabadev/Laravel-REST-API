import { APP_INITIALIZER, NgModule } from '@angular/core';
import { JwtModule } from '@auth0/angular-jwt';
import { AuthService } from './services/auth.service';

function tokenGetter() {
  return localStorage.getItem('session');
}

function initializeApp(authService: AuthService): () => Promise<any> {
  return () =>
    new Promise<void>((resolve, reject) => {
      authService.initializeUser();
      resolve();
    });
}

@NgModule({
  imports: [
    JwtModule.forRoot({
      config: {
        tokenGetter,
        allowedDomains: ['http://orange.localhost:8000'],
        disallowedRoutes: ['http://orange.localhost:8000/api/v1/login'],
      },
    }),
  ],
  providers: [
    {
      provide: APP_INITIALIZER,
      useFactory: initializeApp,
      deps: [AuthService],
      multi: true,
    },
  ],
})
export class CoreModule {}
