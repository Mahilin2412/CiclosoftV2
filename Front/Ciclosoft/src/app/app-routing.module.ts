import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './login/login.component'
import { RegisterCustomerComponent } from './register-customer/register-customer.component';
import { ProductsComponent } from './products/products.component';
import { ProfileCustomerComponent } from './profile-customer/profile-customer.component';
import { CarouselComponent } from './carousel/carousel.component';
import { UpdatePasswordComponent } from './update-password/update-password.component';
import { RecoverPasswordComponent } from './recover-password/recover-password.component';
import { AddProductsComponent } from './add-products/add-products.component';
const routes: Routes = [
  { path: '', component: CarouselComponent},
  { path: 'carousel', component: CarouselComponent},
  { path: 'login', component: LoginComponent },
  { path: 'register-customer',component: RegisterCustomerComponent},
  { path: 'Products', component: ProductsComponent},
  { path: 'profile-customer', component: ProfileCustomerComponent},
  { path: 'update-password', component: UpdatePasswordComponent},
  { path: 'recover-password', component: RecoverPasswordComponent},
  { path: 'AddProducts', component: AddProductsComponent},
  { path: '**', pathMatch: 'full', redirectTo: '/'}
  
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
