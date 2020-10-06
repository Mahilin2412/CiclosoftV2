import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NavbarCLComponent } from './navbar-cl.component';

describe('NavbarCLComponent', () => {
  let component: NavbarCLComponent;
  let fixture: ComponentFixture<NavbarCLComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NavbarCLComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NavbarCLComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
