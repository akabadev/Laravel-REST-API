import { HttpParams } from '@angular/common/http';
import { Component, Input, OnChanges, SimpleChanges } from '@angular/core';
import { IRequestPagination } from '@core/models/requestResult.model';
import { IPageConfig } from '@core/models/utils.model';
import { TYPE_ALERT } from '@core/models/values.config';
import { CrudService } from '@core/services/crud.service';
import { DataTableService } from '@core/services/data-table.service';
import { ExportService } from '@core/services/utils/export.service';
import { ToastrService } from '@core/services/utils/toastr.service';
import { ConfirmationService, SortEvent } from 'primeng/api';
import { Observable } from 'rxjs';
import { finalize, tap } from 'rxjs/operators';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-data-table',
  templateUrl: './data-table.component.html',
  styleUrls: ['./data-table.component.scss'],
})
export class DataTableComponent implements OnChanges {
  @Input() tableConfig: IPageConfig;

  public request: IRequestPagination;
  public datasLoading = true;
  public dataToUpdate: any;
  public addData = false;
  public showActions: boolean;

  private baseUrl: string;
  private lastParams: HttpParams;
  private orderByValue: string;

  get params() {
    const p = this.lastParams ? this.lastParams : new HttpParams();
    return this.orderByValue ? p.append('order-by', this.orderByValue) : p;
  }

  get excelColumns() {
    return this.tableConfig.columns.map((col) => ({
      title: col.header,
      dataKey: col.field,
    }));
  }

  get datas() {
    return this.request?.data.data;
  }

  constructor(
    public exportService: ExportService,
    private dataTableService: DataTableService,
    private confirmationService: ConfirmationService,
    private toastrService: ToastrService,
    private crudService: CrudService
  ) {}

  ngOnChanges(changes: SimpleChanges) {
    if (changes.tableConfig?.currentValue && this.tableConfig) {
      this.showActions =
        this.tableConfig.actions &&
        Object.keys(this.tableConfig.actions).length > 0;
      this.baseUrl = environment.apiUrlOrange + this.tableConfig?.baseURI;
      this.loadData();
    }
  }

  pageChanges(event) {
    this.getDataFromUrl(
      this.baseUrl + this.request.data.links[event.page + 1]?.url
    );
  }
  filterChanges(params: HttpParams) {
    this.lastParams = params;
    this.getDataFromUrl();
  }
  sortChanges($event: SortEvent) {
    const orderByValue = $event.multiSortMeta
      .map((e) => `${e.order > 0 ? '' : '-'}${e.field}`)
      .join(',');
    if (orderByValue !== this.orderByValue) {
      this.orderByValue = orderByValue;
      this.getDataFromUrl();
    }
  }

  getDataFromUrl(url?: string) {
    this.datasLoading = true;
    this.dataTableService
      .getDataFromUrl<IRequestPagination>(url || this.baseUrl, this.params)
      .pipe(finalize(() => (this.datasLoading = false)))
      .subscribe(this.onDataLoad);
  }

  private onDataLoad = (res: IRequestPagination) => {
    if (res) {
      this.request = res;
      this.tableConfig.columns
        .filter((e) => e.type === 'object')
        .forEach((conf) => {
          this.request?.data?.data?.forEach((data) => {
            const value = conf.displayName.match(/[^{\{]+(?=}\})/g);
            const toReplace = conf.displayName.match(/{{(.*?)}}/g);
            data[conf.field].tableDisplayValue = toReplace?.reduce(
              (a, b, i) => {
                return a.replace(
                  b,
                  value[i].split('.').reduce((c, d) => c[d], data[conf.field])
                );
              },
              conf.displayName
            );
          });
        });
    } else {
      alert('Bad credentials.');
    }
  };

  reserializeData(data: any) {
    const { tableDisplayValue, ...dataSerialize } = data;
    return dataSerialize;
  }

  loadData() {
    this.getDataFromUrl(this.baseUrl);
  }

  deleteData(data) {
    this.confirmationService.confirm({
      message: 'Êtes vous sûr de vouloir supprimer ?',
      accept: () => {
        this.crudService.delete(this.baseUrl, data.id).subscribe(() => {
          const msg =
            '<span class="msgOk" style="text-transform: uppercase;">' +
            this.tableConfig.ressourceLabel +
            ' BIEN SUPPRIMÉ</span>';
          this.toastrService.notify(TYPE_ALERT.SUCCESS, msg);
          this.loadData();
        });
      },
    });
  }

  saveData(data) {
    let sub: Observable<any>;
    if (this.addData) {
      sub = this.crudService
        .create(this.baseUrl, data)
        .pipe(tap(() => this.loadData()));
    } else {
      sub = this.crudService
        .update(this.baseUrl, data)
        .pipe(tap(() => this.loadData()));
    }
    sub.subscribe(() => {
      this.addData = null;
      this.dataToUpdate = null;
    });
  }
}
