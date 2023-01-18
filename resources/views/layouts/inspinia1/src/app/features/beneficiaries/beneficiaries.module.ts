import { NgModule } from '@angular/core';
import { SharedModule } from '@shared/shared.module';
import { PaginatorModule } from 'primeng/paginator';
import { TableModule } from 'primeng/table';
import { ToggleButtonModule } from 'primeng/togglebutton';
import { BeneficiariesRoutingModule } from './beneficiaries-routing.module';
import { AddEditBeneficiariesComponent } from './components/add-edit-beneficiaries/add-edit-beneficiaries.component';
import { ListBeneficiariesComponent } from './pages/list-beneficiaries/list-beneficiaries.component';

@NgModule({
  declarations: [ListBeneficiariesComponent, AddEditBeneficiariesComponent],
  imports: [
    SharedModule,
    BeneficiariesRoutingModule,
    TableModule,
    ToggleButtonModule,
    PaginatorModule,
  ],
})
export class BeneficiariesModule {}
