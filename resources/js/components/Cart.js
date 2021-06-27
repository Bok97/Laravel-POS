import React, {Component} from 'react';
import ReactDOM from "react-dom";
import axios from 'axios';
import { sum } from "lodash";
import Swal from "sweetalert2";
import { Button } from 'bootstrap';


class Cart extends Component{

    constructor(props){
        super(props)
        this.state = {
            cart: [],
            products: [],
            customers: [],
            search: "",
            customer_id: ""
        };

        //cart
        this.loadCart = this.loadCart.bind(this);
        this.ChangeQty = this.ChangeQty.bind(this);
        this.EmptyCart = this.EmptyCart.bind(this);
        //product
        this.loadProducts = this.loadProducts.bind(this);
        this.searchProduct = this.searchProduct.bind(this);
        this.keySearch = this.keySearch.bind(this);
        //customer
        this.setCustomerId = this.setCustomerId.bind(this);
        //order
        this.ClickSubmit = this.ClickSubmit.bind(this)


    }

    componentDidMount(){
        this.loadCart();
        this.loadCustomers();
        this.loadProducts();
    }

    loadCart(){
        axios.get('/admin/cart').then(res => {
            const cart = res.data;
            this.setState({cart})
        })
    }

    loadCustomers() {
        axios.get(`/admin/customers`).then(res => {
            const customers = res.data;
            this.setState({ customers });
        });
    }

    loadProducts(search = ""){
        const query = !!search ? `?search=${search}` : "";
        axios.get(`/admin/products${query}`).then(res => {
            const products = res.data.data;
            this.setState({ products });
        });
    }

    searchProduct(event){
        const search = event.target.value;
        this.setState({ search });
    }

    keySearch(event){
        if (event.keyCode === 13) {
            this.loadProducts(event.target.value);
        }
    }
    
    ChangeQty(product_id, qty){
        const cart = this.state.cart.map(c => {
            if (c.id === product_id) {
                c.pivot.quantity = qty;
            }
            return c;
        });
        this.setState({ cart });
        axios
            .post("/admin/cart/changeQty", { product_id, quantity: qty }).then(res => {})
            .catch(err =>{
                Swal.fire("Error!", err.response.data.message, "error");
            });
    }

    addQty(id){
        axios
            .post("/admin/cart/addQty", { id })
            .then(res => {
                this.loadCart();
                this.setState({ id: "" });
            })
            .catch(err => {
                Swal.fire("Error!", err.response.data.message, "error");
            });
    }
    minusQty(id){
        axios
            .post("/admin/cart/minusQty", { id })
            .then(res => {
                this.loadCart();
                this.setState({ id: "" });
            })
            .catch(err => {
                Swal.fire("Error!", err.response.data.message, "error");
            });
    }

    addToCart(id) {
        axios
            .post("/admin/cart", { id })
            .then(res => {
                this.loadCart();
                this.setState({ id: "" });
            })
            .catch(err => {
                Swal.fire("Error!", err.response.data.message, "error");
            });
    }

    setCustomerId(event) {
        this.setState({ customer_id: event.target.value });
    }

    getSubTotal(cart){
        const total = cart.map(c => c.pivot.quantity * c.price);
        return sum(total).toFixed(2);
    }

    getTotalItem(cart){
        const total = cart.map(c => c.pivot.quantity);
        return sum(total);
    }

    getTotal(cart){
        const subTotal = eval(this.getSubTotal(cart));
        const tax = subTotal * 0.06;         
        const total =  subTotal + tax;
        return total.toFixed(2);
    }


    ClickDelete(product_id) {
        axios
            .post("/admin/cart/delete", { product_id, _method: "DELETE" })
            .then(res => {
                const cart = this.state.cart.filter(c => c.id !== product_id);
                this.setState({ cart });
            });
    }
    
    EmptyCart() {
        Swal.fire({
            title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            preConfirm: () => {
                return  axios.post("/admin/cart/empty", { _method: "DELETE" }).then(res => {
                    this.setState({ cart: [] });
                }).catch(err => {
                    Swal.showValidationMessage(err.response.data.message)
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.value) {
                Swal.fire('Cancel Successfully', '', 'success')  
            }
        })
    }

    ClickSubmit() {
        Swal.fire({
            title: 'Confirm Transaction Amount',
            input: 'text',
            inputValue: this.getTotal(this.state.cart),
            showCancelButton: true,
            confirmButtonText: 'Submit',
            showLoaderOnConfirm: true,
            preConfirm: (amount) => {
                return axios.post('/admin/orders', {customer_id: this.state.customer_id, amount}).then(res => {
                    this.loadCart();
                    return res.data;
                }).catch(err => {
                    Swal.showValidationMessage(err.response.data.message)
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.value) {
                Swal.fire('Transaction Successfully', '', 'success')  
            }
        })
    }
    render(){
        const {cart, products, customers} = this.state;
        return(
            <div className="row">
                <div className="col-md-6 col-lg-4">
                    <div className="row mb-2">
                        <div className="col">
                            <select className="form-control" onChange={this.setCustomerId}>
                                <option value="">Walking Customer</option>
                                {customers.map(cus => (
                                    <option key={cus.id} value={cus.id}>{cus.name}</option>
                                ))}
                            </select>
                        </div>
                    </div>
                    <div className="user-cart">
                        <div className="card">
                            <table className="table table-strped">
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th></th>
                                    <th>Quantity</th>
                                    <th></th>
                                    <th className="text-right">Price</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                {cart.map(c=>(
                                    <tr key={c.id}>
                                        <td>{c.name}</td>
                                        <td><button className="btn btn-warning btn-sm" onClick={() => this.minusQty(c.id)}>-</button></td>
                                        <td>
                                            <input type="text" className="form-control form-control-sm qty" value={c.pivot.quantity}
                                                onChange={event =>this.ChangeQty(c.id,event.target.value)} readOnly/>
                                        </td>
                                        <td><button className="btn btn-success btn-sm" onClick={() => this.addQty(c.id)}>+</button></td>
                                        <td className="text-right">RM{(c.price * c.pivot.quantity).toFixed(2)}</td>
                                        <td>
                                            <button className="btn btn-danger btn-sm" onClick={() => this.ClickDelete(c.id)}>
                                                <i className="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                                </tbody>
                            </table>
                        </div>
                        <div className="row">
                            <div className="col">Subtotal:</div>
                            <div className="col text-right">RM{this.getSubTotal(cart)}</div>
                        </div>
                        <div className="row">
                            <div className="col">No. of Items:</div>
                            <div className="col text-right">{this.getTotalItem(cart)}</div>
                        </div>
                        <div className="row">
                            <div className="col">Total:</div>
                            <div className="col text-right">RM{this.getTotal(cart)}</div>
                        </div>
                        <div className="row">
                            <div className="col">
                                <button type="button" className="btn btn-danger btn-block"  onClick={this.EmptyCart} disabled={!cart.length} >Cancel</button>
                            </div>
                            <div className="col">
                                <button type="button" className="btn btn-primary btn-block" onClick={this.ClickSubmit} disabled={!cart.length}>Check Out</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-md-6 col-lg-8">
                    <div className="mb-3">
                        <input type="text" className="form-control" placeholder="Search Product" onChange={this.searchProduct} onKeyDown={this.keySearch}/>
                    </div>
                    <div className="order-product">
                        {products.map(p => (
                        <div className="item"  onClick={() => this.addToCart(p.id)} key={p.id}>
                            <img src={p.image_url} alt=""/>
                            <h5>{p.name}</h5>
                        </div>
                        ))}
                    </div>
                </div>
            </div>
        );
    }
}

export default Cart;
if (document.getElementById("cart")) {
    ReactDOM.render(<Cart />, document.getElementById("cart"));
}