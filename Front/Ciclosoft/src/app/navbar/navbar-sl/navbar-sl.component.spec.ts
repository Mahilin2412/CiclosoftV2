import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NavbarSLComponent } from './navbar-sl.component';

describe('NavbarSLComponent', () => {
  let component: NavbarSLComponent;
  let fixture: ComponentFixture<NavbarSLComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NavbarSLComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NavbarSLComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
