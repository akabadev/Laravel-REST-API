import { NgModule } from '@angular/core';
import { SharedModule } from '@shared/shared.module';
import { TableModule } from 'primeng/table';
import { AddEditUserComponent } from './pages/add-edit-user/add-edit-user.component';
import { ListUserComponent } from './pages/list-user/list-user.component';
import { UsersRoutingModule } from './users-routing.module';
import { ToggleButtonModule } from 'primeng/togglebutton';
import { PaginatorModule } from 'primeng/paginator';

const COMPONENTS = [AddEditUserComponent, ListUserComponent];

@NgModule({
  declarations: [COMPONENTS],
  imports: [SharedModule, UsersRoutingModule, TableModule, ToggleButtonModule, PaginatorModule],
})
export class UsersModule {}
