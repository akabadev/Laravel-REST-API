import { ComponentFixture, TestBed } from '@angular/core/testing';

import { FormGroupGeneratedComponent } from './form-group-generated.component';

describe('FormGroupGeneratedComponent', () => {
  let component: FormGroupGeneratedComponent;
  let fixture: ComponentFixture<FormGroupGeneratedComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ FormGroupGeneratedComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(FormGroupGeneratedComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
