import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AddEditUserComponent } from './pages/add-edit-user/add-edit-user.component';
import { ListUserComponent } from './pages/list-user/list-user.component';

const routes: Routes = [
  {
    path: '',
    component: ListUserComponent,
    data: { title: 'Liste Utilisateurs' },
  },
  {
    path: 'edit-user/:id',
    component: AddEditUserComponent,
    data: {
      title: 'Modifier un utilisateur',
    },
  },
  {
    path: 'add-user',
    component: AddEditUserComponent,
    data: {
      title: 'Ajouter un utilisateur',
    },
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class UsersRoutingModule {}
