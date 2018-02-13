import React, { Component } from 'react';
import style from '../button/style.module.css';

export default class URL extends Component {
    onChange = (event) => {
        this.props.onChange && this.props.onChange(event.target.value, this.props.name);
    };
    render() {
        return (
            <div className={style.label}>
                <label>
                    {this.props.label}
                </label>
                <input placeholder="https://" onChange={this.onChange} type="url" defaultValue={this.props.value}/>
            </div>
        );
    }
}