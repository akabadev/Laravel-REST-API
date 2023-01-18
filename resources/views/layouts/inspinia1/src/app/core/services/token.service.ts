import { Injectable } from '@angular/core';
import { IUser } from '@core/models/user';
import { ISession } from '../models/session.interface';

@Injectable({
  providedIn: 'root',
})
export class TokenService {
  constructor() {}

  get session(): ISession {
    return JSON.parse(localStorage.getItem('session'));
  }

  setSession(token: string, user: IUser) {
    const session: ISession = {
      token,
      user,
    };
    localStorage.setItem('session', JSON.stringify(session));
  }

  resetSession(): any {
    localStorage.removeItem('session');
    localStorage.removeItem('name');
  }

  loggedIin() {
    const token = localStorage.getItem('session');
    return !!token;
  }
}
