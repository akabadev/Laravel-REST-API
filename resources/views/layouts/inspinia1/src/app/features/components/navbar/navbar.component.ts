import { Component, HostListener } from '@angular/core';
import { Router } from '@angular/router';
import { TYPE_ALERT } from '@core/models/values.config';
import { AuthService } from '@core/services/auth.service';
import { ConfigService, IMenu } from '@core/services/config.service';
import { ToastrService } from '@core/services/utils/toastr.service';
import { UserPreferencesService } from '@core/services/utils/user-preferences.service';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.scss'],
})
export class NavbarComponent {
  public hovered = false;
  public navigationItems$: Observable<IMenu[]>;

  public userItems = [
    {
      label: 'Profil',
      routerLink: '/auth/login',
    },
    {
      label: 'Mot de passe',
      routerLink: '/auth/forgot-password',
    },
    {
      label: 'Déconnexion',
      routerLink: '/auth/logout',
    },
  ];

  constructor(
    public authService: AuthService,
    private router: Router,
    private toastrService: ToastrService,
    public userPreferencesService: UserPreferencesService,
    private configService: ConfigService,
  ) {
    this.navigationItems$ = configService.getMenuConfig();
  }

  @HostListener('mouseenter')
  enterHover() {
    this.hovered = true;
  }
  @HostListener('mouseleave')
  leaveHover() {
    this.hovered = false;
  }

  signOut() {
    this.toastrService
      .optionsWithDetails(
        `êtes vous sûr de vouloir quitter?`,
        600,
        `<span><i class="anticon anticon-lock"></i> VALIDER</span>`,
        `<span><i class="anticon anticon-lock"></i> ANNULER</span>`
      )
      .then((res) => {
        if (res) {
          this.authService.logout();
          const msg = '<span class="msgOk">VOUS ÊTES BIEN DÉCONNECTÉ</span>';
          this.toastrService.notify(TYPE_ALERT.ERROR, msg);
          this.router.navigate(['/auth']);
        }
      });
  }

  toggleMenuState() {
    this.userPreferencesService.setMenuState(
      this.userPreferencesService.menuState === 'opened' ? 'closed' : 'opened'
    );
  }
}
