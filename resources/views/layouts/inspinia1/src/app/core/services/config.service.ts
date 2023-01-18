import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { IRequestResult } from '@core/models/requestResult.model';
import { IPageConfig } from '@core/models/utils.model';
import { MenuItem } from 'primeng/api';
import { Observable, of } from 'rxjs';
import { map, take, tap } from 'rxjs/operators';
import { environment } from 'src/environments/environment';

export interface IMenu extends MenuItem {
  page: number;
  items: IMenu[];
}
@Injectable({
  providedIn: 'root',
})
export class ConfigService {
  constructor(private http: HttpClient) {}

  getMenuConfig(): Observable<IMenu[]> {
    return this.http
      .get<IRequestResult<IMenu[]>>(environment.apiUrlOrange + 'account/menus')
      .pipe(
        take(1),
        map((e) =>
          e.data.map((menu) => {
            menu.queryParams = { view: menu.page };
            menu.items?.forEach(
              (item) => (item.queryParams = { view: item.page })
            );
            return menu;
          })
        )
      );
  }

  getPageConfig(view: number): Observable<IPageConfig> {
    return this.http
      .get<IRequestResult<IPageConfig>>(
        environment.apiUrlOrange + 'pages/' + view + '/config'
      )
      .pipe(
        take(1),
        map((e) => e.data)
      );
  }
}
