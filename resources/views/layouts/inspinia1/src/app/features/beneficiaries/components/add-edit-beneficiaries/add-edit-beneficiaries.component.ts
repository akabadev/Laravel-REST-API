import {
  Component,
  EventEmitter,
  Input,
  OnChanges,
  Output,
  SimpleChanges,
} from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { IBeneficiary } from '@core/models/beneficiaries.model';

@Component({
  selector: 'app-add-edit-beneficiaries',
  templateUrl: './add-edit-beneficiaries.component.html',
  styleUrls: ['./add-edit-beneficiaries.component.scss'],
})
export class AddEditBeneficiariesComponent implements OnChanges {
  @Input() beneficiary: IBeneficiary;
  @Input() display = false;
  @Output() canceled = new EventEmitter();
  @Output() saveBeneficiary = new EventEmitter<IBeneficiary>();

  public beneficiaryForm: FormGroup;

  constructor() {}

  ngOnChanges(changes: SimpleChanges): void {
    if (changes.beneficiary) {
      this.beneficiaryForm = new FormBuilder().group({
        id: [this.beneficiary?.id],
        code: [this.beneficiary?.code, Validators.required],
        last_name: [this.beneficiary?.last_name, Validators.required],
        first_name: [this.beneficiary?.last_name, Validators.required],
        address: [this.beneficiary?.address, Validators.required],
        profil: [this.beneficiary?.profile, Validators.required],
        service: [this.beneficiary?.service, Validators.required],
        email: [this.beneficiary?.email, [Validators.required, Validators.email]],
        active: [this.beneficiary?.active ?? true],
      });
    }
  }

  submit() {
    this.beneficiaryForm.markAllAsTouched();
    if (this.beneficiaryForm.valid) {
      let toUpdate;
      if (this.beneficiary) {
        toUpdate = {} as IBeneficiary;
        for (let key in this.beneficiaryForm.value) {
          if (this.beneficiary[key] !== this.beneficiaryForm.value[key]) {
            toUpdate[key] = this.beneficiaryForm.value[key];
          }
        }
        toUpdate.id = this.beneficiary.id;
      } else {
        toUpdate = this.beneficiaryForm.value as IBeneficiary;
      }
      this.saveBeneficiary.emit(toUpdate);
    }
  }
}
