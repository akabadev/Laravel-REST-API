import { OnInit } from '@angular/core';
import {
  Component,
  EventEmitter,
  Input,
  OnChanges,
  Output,
} from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { IUser } from '@core/models/user';
export interface ConfirmModel {
  title: string;
  messageModal: string;
}

@Component({
  selector: 'app-add-edit-user',
  templateUrl: './add-edit-user.component.html',
  styleUrls: ['./add-edit-user.component.scss'],
})
export class AddEditUserComponent implements OnChanges {
  @Input() user: IUser;
  @Input() display = false;
  @Output() canceled = new EventEmitter();
  @Output() saveUser = new EventEmitter<IUser>();

  public userForm: FormGroup;

  constructor() {}

  ngOnChanges(): void {
    this.userForm = new FormBuilder().group({
      id: [this.user?.id, Validators.required],
      name: [this.user?.name, Validators.required],
      email: [this.user?.email, [Validators.required, Validators.email]],
      enable: [this.user ? this.user.enable : true],
    });
    this.userForm.get('id').disable();
  }

  submit() {
    this.userForm.markAllAsTouched();
    if (this.userForm.valid) {
      let toUpdate;
      if (this.user) {
        toUpdate = {} as IUser;
        for (let key in this.userForm.value) {
          if (this.user[key] !== this.userForm.value[key]) {
            toUpdate[key] = this.userForm.value[key];
          }
        }
        toUpdate.id = this.user.id;
      } else {
        toUpdate = this.userForm.value as IUser;
      }
      this.saveUser.emit(toUpdate);
    }
  }
}
