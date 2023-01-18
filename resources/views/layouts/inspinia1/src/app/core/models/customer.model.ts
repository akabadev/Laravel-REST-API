import { IAddress } from './address.model';

export interface ICustomer {
  id: number;
  code: string;
  bo_reference: string;
  name: string;
  contact_name: string;
  active: boolean;
  address_id: number;
  address: IAddress;
}
