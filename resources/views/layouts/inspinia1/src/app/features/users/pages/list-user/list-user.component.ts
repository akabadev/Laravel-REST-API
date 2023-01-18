import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { IPageConfig } from '@core/models/utils.model';
import { ConfigService } from '@core/services/config.service';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-list-user',
  templateUrl: './list-user.component.html',
  styleUrls: ['./list-user.component.scss'],
})
export class ListUserComponent implements OnInit {
  public pageConfig$: Observable<IPageConfig>;

  constructor(
    private configService: ConfigService,
    private ar: ActivatedRoute
  ) {}

  ngOnInit() {
    this.pageConfig$ = this.configService.getPageConfig(
      this.ar.snapshot.queryParams.view
    );
  }
}
