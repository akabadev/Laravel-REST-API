import { Component } from '@angular/core';
import { UserPreferencesService } from '@core/services/utils/user-preferences.service';

@Component({
  selector: 'app-features',
  templateUrl: './features.component.html',
  styleUrls: ['./features.component.scss'],
})
export class FeaturesComponent {
  constructor(public userPreferencesService: UserPreferencesService) {}
}
