import React, { Component } from 'react';
import style from '../button/style.module.css';

export default class URLS extends Component {
    add = () => {
        this.onChange(['']);
    };
    remove = (event) => {
        let tr = event.target.parentNode.parentNode;
        tr.querySelector('input').value = '';

        this.onChange();
    };

    onChange = (plus) => {
        let  urls = [];
        urls = [].slice.call(this.refs.table.querySelectorAll('input')).map(input => input.value).filter(elm => elm);

        if (Array.isArray(plus)) {
            urls = urls.concat(plus);
        }

        this.props.onChange && this.props.onChange(urls, this.props.name);
    };

    render() {
        console.log('render');
        const urls = ((this.props.value && Array.isArray(this.props.value) && this.props.value.length) ? this.props.value : ['']).map((url, index) => {
            return (<tr key={index + '' + url}>
                <td>
                    <input placeholder="https://" onBlur={this.onChange} type="url"  defaultValue={url}/>
                </td>
                <td className={style.fill}>
                    <span onClick={this.add} className={style.add}></span>
                    <span onClick={this.remove} className={style.trash}></span>
                </td>
            </tr>);
        });
        return (
            <div className={style.label}>
                <label>
                    {this.props.label}
                </label>
                <table className={style.table} ref="table">
                    <tbody>
                      {urls}
                    </tbody>
                </table>
            </div>
        );
    }
}