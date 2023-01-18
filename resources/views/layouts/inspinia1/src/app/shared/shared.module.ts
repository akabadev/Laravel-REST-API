import { CommonModule } from '@angular/common';
import { NgModule } from '@angular/core';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { AddEditDataComponent } from './components/add-edit-data/add-edit-data.component';
import { DataTableComponent } from './components/data-table/data-table.component';
import { NgCommonModule } from './modules/ng-common.module';
import { FormGroupGeneratedComponent } from './components/data-table/components/form-group-generated/form-group-generated.component';
import { ListFiltersComponent } from './components/data-table/components/list-filters/list-filters.component';

const MODULES = [
  CommonModule,
  FormsModule,
  ReactiveFormsModule,
  NgCommonModule,
];
const COMPONENTS = [
  DataTableComponent,
  AddEditDataComponent,
  ListFiltersComponent,
];
@NgModule({
  declarations: [COMPONENTS, FormGroupGeneratedComponent],
  imports: [MODULES],
  exports: [MODULES, COMPONENTS],
})
export class SharedModule {}
