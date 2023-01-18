import { IUser } from './user';

export interface ISession {
  // expireIn: string;
  user?: IUser;
  token?: string;
}
