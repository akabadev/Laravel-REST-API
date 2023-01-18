import { IRequestPagination, IRequestResult } from './requestResult.model';

export class IUser {
  id: number | undefined;
  email: string;
  name: string | undefined;
  api_token?: string | undefined;
  password: string | undefined;
  token: string | undefined;
  email_verified_at: Date;
  deleted_at?: Date;
  created_at: Date;
  updated_at: Date;
  enable: boolean; // TODO à changer selon l'API
}
