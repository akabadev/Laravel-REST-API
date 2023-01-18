import { AfterViewInit, Component } from '@angular/core';
import { NgxSpinnerService } from 'ngx-spinner';

@Component({
  selector: 'app-auth-home',
  templateUrl: './auth-home.component.html',
  styleUrls: ['./auth-home.component.scss'],
})
export class AuthHomeComponent implements AfterViewInit {
  constructor(private spinner: NgxSpinnerService) {}

  ngAfterViewInit() {
    document
      .querySelector('.wrapper')
      .classList.add('bg-home' +(Math.round(Math.random() * 17) + 1));
  }

  showSpinner() {
    setTimeout(() => {
      this.spinner.hide();
    }, 2000);
  }
}
