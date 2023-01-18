import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AddEditBeneficiariesComponent } from './add-edit-beneficiaries.component';

describe('AddEditBeneficiariesComponent', () => {
  let component: AddEditBeneficiariesComponent;
  let fixture: ComponentFixture<AddEditBeneficiariesComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AddEditBeneficiariesComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AddEditBeneficiariesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
