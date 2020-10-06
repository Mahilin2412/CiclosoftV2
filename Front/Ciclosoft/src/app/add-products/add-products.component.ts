import { Component, OnInit } from '@angular/core';
import { ServiceProducts } from '../Services/ServiceProducts';

@Component({
  selector: 'app-add-products',
  templateUrl: './add-products.component.html',
  styleUrls: ['./add-products.component.css']
})
export class AddProductsComponent implements OnInit {
  NamePr : String;
  RefePr : String; 
  dire: String;
  constructor(private productServ: ServiceProducts) { }

  ngOnInit() {
  }
  onFileChanges(files){
    console.log("File Change by method :: ", files)
    this.dire = files[0].base64;
  }

  goBack(): void {
    //this.location.back();
  }

  UpdateChanges(): void {
    //this.InputsDisabled = true;
    let Datapost = {
      imageProduct: this.dire,
      IdResponse: 0,
      Response: ""
    }
    this.productServ.updateProducts(Datapost)
      .subscribe(() => this.goBack());
  }
}
