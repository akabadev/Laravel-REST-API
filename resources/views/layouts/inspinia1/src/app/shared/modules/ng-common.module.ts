import { NgModule } from '@angular/core';
import { ButtonModule } from 'primeng/button';
import { DialogModule } from 'primeng/dialog';
import { InputSwitchModule } from 'primeng/inputswitch';
import { InputTextModule } from 'primeng/inputtext';
import { TooltipModule } from 'primeng/tooltip';
import { CardModule } from 'primeng/card';
import { ConfirmDialogModule } from 'primeng/confirmdialog';
import { ConfirmationService } from 'primeng/api';
import { TableModule } from 'primeng/table';
import { ToggleButtonModule } from 'primeng/togglebutton';
import { PaginatorModule } from 'primeng/paginator';
import { TriStateCheckboxModule } from 'primeng/tristatecheckbox';

const MODULES = [
  InputSwitchModule,
  ButtonModule,
  TooltipModule,
  InputTextModule,
  DialogModule,
  CardModule,
  ConfirmDialogModule,
  TableModule,
  ToggleButtonModule,
  PaginatorModule,
  TriStateCheckboxModule
];
@NgModule({
  imports: [MODULES],
  exports: [MODULES],
  providers: [ConfirmationService],
})
export class NgCommonModule {}
