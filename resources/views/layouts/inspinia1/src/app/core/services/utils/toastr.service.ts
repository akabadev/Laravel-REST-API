import { Injectable } from '@angular/core';
import { TYPE_ALERT } from '@core/models/values.config';
import Swal, { SweetAlertResult } from 'sweetalert2';

@Injectable({
  providedIn: 'root',
})
export class ToastrService {
  constructor() {}

  notify(
    icon = TYPE_ALERT.SUCCESS,
    title: string = ''
  ): Promise<SweetAlertResult<any>> {
    return Swal.fire({
      toast: true,
      position: 'top',
      showConfirmButton: false,
      timer: 3000,
      background: '#f4f6fa',
      width: '400px',
      icon,
      title,
    });
  }

  optionsWithDetails(
    title: string,
    width: number | string,
    confirmButtonText: string = '',
    cancelButtonText: string = ''
  ) {
    return Swal.fire({
      title,
      icon: 'warning',
      width: `${width}px`,
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText,
      cancelButtonText,
      showCloseButton: true,
    }).then((result) => result.isConfirmed);
  }
}
