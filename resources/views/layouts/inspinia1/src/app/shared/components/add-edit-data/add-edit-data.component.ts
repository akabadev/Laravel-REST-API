import {
  Component,
  EventEmitter,
  Input,
  OnChanges,
  Output,
  SimpleChanges,
} from '@angular/core';
import {
  AbstractControl,
  FormControl,
  FormGroup,
  Validators,
} from '@angular/forms';
import { IPageConfig } from '@core/models/utils.model';

@Component({
  selector: 'app-add-edit-data',
  templateUrl: './add-edit-data.component.html',
  styleUrls: ['./add-edit-data.component.scss'],
})
export class AddEditDataComponent implements OnChanges {
  @Input() tableConfig: IPageConfig;
  @Input() display: boolean;
  @Input() data;
  @Output() canceled = new EventEmitter();
  @Output() saveBeneficiary = new EventEmitter();

  public formGroup: FormGroup;
  constructor() {}

  ngOnChanges(changes: SimpleChanges): void {
    if (changes.tableConfig) {
      const group = this.generateFormGroup();
      this.formGroup = new FormGroup(group);
    }
    if (changes.data) {
      this.formGroup?.patchValue(this.data);
    }
  }

  generateFormGroup(formConfig = this.tableConfig.form): {
    [key: string]: AbstractControl;
  } {
    const controls: { [key: string]: AbstractControl } = {};
    if (formConfig) {
      for (const key in formConfig) {
        if (key && formConfig[key].canEdit) {
          if (!formConfig[key].children) {
            const validators = formConfig[key].rules?.map((e) => {
              return Validators.required;
            });
            controls[key] = new FormControl(this.data?.[key], validators);
          } else {
            controls[key] = new FormGroup(
              this.generateFormGroup(formConfig[key].children)
            );
          }
        }
      }
    }
    return controls;
  }

  submit() {
    this.formGroup.markAllAsTouched();
    if (this.formGroup.valid) {
      this.saveBeneficiary.emit(this.formGroup.value);
    }
  }

  /*
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
   */
}
