import { HttpParams } from '@angular/common/http';
import {
  Component,
  EventEmitter,
  Input,
  OnDestroy,
  OnInit,
  Output,
} from '@angular/core';
import { IPageConfig } from '@core/models/utils.model';
import { Subject, Subscription } from 'rxjs';
import { debounceTime } from 'rxjs/operators';

@Component({
  selector: 'app-list-filters',
  templateUrl: './list-filters.component.html',
  styleUrls: ['./list-filters.component.scss'],
})
export class ListFiltersComponent implements OnInit, OnDestroy {
  @Input() tableConfig: IPageConfig;
  @Output() filterChanges = new EventEmitter<HttpParams>();
  private _debonceIt: Subscription;
  private debounceIt = new Subject();

  public filter = {};

  get params(): HttpParams {
    return new HttpParams({
      fromObject: Object.entries(this.filter).reduce(
        (acc, [key, value]) =>
          value !== undefined && value !== null && value !== ''
            ? ((acc[key] = value), acc)
            : acc,
        {}
      ),
    });
  }

  ngOnInit() {
    this._debonceIt = this.debounceIt.pipe(debounceTime(750)).subscribe(() => {
      this.filterChanges.emit(this.params);
    });
  }

  ngOnDestroy() {
    this._debonceIt?.unsubscribe();
  }

  onChanges() {
    this.debounceIt.next();
  }
}
