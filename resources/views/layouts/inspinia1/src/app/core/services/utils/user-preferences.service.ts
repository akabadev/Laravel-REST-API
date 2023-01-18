import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class UserPreferencesService {
  get menuState(): 'opened' | 'closed' {
    return (
      (localStorage.getItem('menuState') as 'opened' | 'closed') ?? 'closed'
    );
  }
  constructor() {}

  setMenuState(state: 'opened' | 'closed'): void {
    localStorage.setItem('menuState', state);
  }
}
