import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { TYPE_ALERT } from '@core/models/values.config';
import { AuthService } from '@core/services/auth.service';
import { ToastrService } from '@core/services/utils/toastr.service';

@Component({
  selector: 'app-topbar',
  templateUrl: './topbar.component.html',
  styleUrls: ['./topbar.component.scss'],
})
export class TopbarComponent implements OnInit {

  constructor(
    public authService: AuthService,
    private router: Router,
    private toastrService: ToastrService
  ) {}

  ngOnInit(): void {}

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
}
