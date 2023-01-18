import { IAddress } from './address.model';
import { IRequestPagination, IRequestResult } from './requestResult.model';
import { IService } from './service.model';

export interface IBeneficiary {
  id: number;
  code: string;
  first_name: string;
  last_name: string;
  email: string;
  profile: string;
  address: IAddress;
  active: boolean;
  service: IService;
}
export interface ISendBeneficiary {
  id: number;
  code: string;
  first_name: string;
  last_name: string;
  email: string;
  profile: string;
  address_id: number;
  service_id: number;
}
