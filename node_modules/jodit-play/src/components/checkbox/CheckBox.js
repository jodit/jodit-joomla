import React, { Component } from 'react';
import style from './style.module.css';
import Toggle from 'react-toggle'
import "react-toggle/style.css"

export default class CheckBox extends Component {
    onChange = (event) => {
        this.props.onChange && this.props.onChange(event.target.checked, this.props.name);
    };
    render() {
        return (
            <div className={style.label + (this.props.right ? ' ' + style.right : '')}>
                <label>
                    {this.props.checked !== undefined ?
                        <Toggle
                            defaultChecked={this.props.defaultChecked}
                            checked={this.props.checked}
                            onChange={this.onChange}
                        />
                        :
                        <Toggle
                            defaultChecked={this.props.defaultChecked}
                            onChange={this.onChange}
                        />
                    }
                    <span className={style.labelText}>{this.props.label}</span>
                </label>
            </div>
        );
    }
}