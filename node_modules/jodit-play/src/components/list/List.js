import React, { Component } from 'react';
import style from './style.module.css';

export default class List extends Component {
    onChange = () => {
        this.props.onChange && this.props.onChange(this.refs.elm.value, this.props.name);
    };
    render() {
        const keys = Array.isArray(this.props.list) ? this.props.list : Object.keys(this.props.list);

        const listItems = keys.map((key) => (
            <option key={key} value={key}>
                {Array.isArray(this.props.list) ? key : this.props.list[key]}
            </option>
        ));

        return (
            <div className={style.list}>
                <label className={style.label}>
                    {this.props.label}
                </label>
                <select defaultValue={this.props.value} className={style.select} ref="elm" onChange={this.onChange}>
                    {listItems}
                </select>
            </div>
        );
    }
}