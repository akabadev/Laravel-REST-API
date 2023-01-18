import { IAddress } from './address.model';
import { ICustomer } from './customer.model';
import { IRequestPagination } from './requestResult.model';

export interface IService {
  id: number;
  code: string;
  bo_reference: string;
  customer_id: number;
  name: string;
  contact_name: string;
  address_id: number;
  delivery_site: string;
  active: boolean;
  address: IAddress;
  customer: ICustomer;
}
