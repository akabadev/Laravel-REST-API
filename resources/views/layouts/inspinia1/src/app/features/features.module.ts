import { NgModule } from '@angular/core';
import { SharedModule } from '../shared/shared.module';
import { FooterComponent } from './components/footer/footer.component';
import { NavbarComponent } from './components/navbar/navbar.component';
import { TopbarComponent } from './components/topbar/topbar.component';
import { FeaturesRoutingModule } from './features-routing.module';
import { FeaturesComponent } from './features.component';
import { HomePageComponent } from './pages/home-page/home-page.component';
import { RippleModule } from 'primeng/ripple';
import { PanelMenuModule } from 'primeng/panelmenu';
import { MenuModule } from 'primeng/menu';
import { BreadcrumbsComponent } from './components/breadcrumbs/breadcrumbs.component';
import { BreadcrumbModule } from 'primeng/breadcrumb';

const COMPONENTS = [
  NavbarComponent,
  FooterComponent,
  TopbarComponent,
  FeaturesComponent,
  BreadcrumbsComponent,
];

@NgModule({
  declarations: [COMPONENTS, HomePageComponent],
  imports: [
    SharedModule,
    FeaturesRoutingModule,
    RippleModule,
    PanelMenuModule,
    MenuModule,
    BreadcrumbModule,
  ],
})
export class FeaturesModule {}
