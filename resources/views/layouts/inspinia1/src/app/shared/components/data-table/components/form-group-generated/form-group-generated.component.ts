import { Component, Input, OnInit } from '@angular/core';
import { AbstractControl, FormGroup } from '@angular/forms';
import { IFormConfig } from '@core/models/utils.model';

@Component({
  selector: 'app-form-group-generated',
  templateUrl: './form-group-generated.component.html',
  styleUrls: ['./form-group-generated.component.scss']
})
export class FormGroupGeneratedComponent implements OnInit {
  @Input() formConfig: IFormConfig;
  @Input() formGroup: FormGroup;

  public keyOfFormConfig: string[];
  constructor() { }

  ngOnInit(): void {
    this.keyOfFormConfig = Object.keys(this.formConfig).filter(e => this.formConfig[e].canEdit);
  }


  controlAsFormGroup(control: AbstractControl) {
    return control as FormGroup;
  }
}
