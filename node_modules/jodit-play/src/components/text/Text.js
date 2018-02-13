import React, { Component } from 'react';
import style from './style.module.css';

export default class Text extends Component {
    onChange = (event) => {
        this.props.onChange && this.props.onChange(event.target.value, this.props.name);
    };
    render() {
        return (
            <div className={style.label}>
                <label>
                    {this.props.label}
                </label>
                <textarea onChange={this.onChange} defaultValue={this.props.value}/>
            </div>
        );
    }
}