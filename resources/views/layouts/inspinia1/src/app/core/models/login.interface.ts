import { IRequestResult } from './requestResult.model';
import { IUser } from './user';

export interface ILoginForm {
  email: string;
  password: string;
}

export interface IResultLogin extends IRequestResult{
  data: {
    token?: string;
    user?: IUser;
  };
}
