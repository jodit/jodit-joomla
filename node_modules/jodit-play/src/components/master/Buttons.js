import React, { Component } from 'react';
import Button from "../button/Button";
import style from '../button/style.module.css';
import Separator from "../button/Separator";
import Break from "../button/Break";
import Jodit from "jodit";


export default class Buttons extends Component {
    toggleAll = () => {
        const buttons = [...this.props.buttons];
        const removeButtons = [...this.props.removeButtons];

        buttons.forEach((button, index) => {
            if (removeButtons.indexOf(button) !== -1) {
                removeButtons.splice(removeButtons.indexOf(button), 1);
            } else {
                removeButtons.push(button);
            }
        });

        this.props.setButtons(
            this.props.name,
            buttons,
            removeButtons,
            this.props.activeIndex
        );
    };
    toggle = (index, active) => {
        const button = this.props.buttons[index];
        const removeButtons = [...this.props.removeButtons];

        if (removeButtons.indexOf(button) !== -1 && active) {
            removeButtons.splice(removeButtons.indexOf(button), 1);
        } else {
            !active && removeButtons.push(button);
        }

        this.props.setButtons(
            this.props.name,
            this.props.buttons,
            removeButtons,
            this.props.activeIndex
        );
    };
    move = (index, up) => {
        const buttonsStart = this.props.buttons.slice();
        const next = index + (up ? -1 : 1);
        const buf = buttonsStart[index];

        buttonsStart[index] = buttonsStart[next];
        buttonsStart[next] = buf;

        this.props.setButtons(
            this.props.name,
            buttonsStart,
            this.props.removeButtons,
            this.props.activeIndex
        );
    };
    remove = (index) => {
        const buttonsStart = this.props.buttons.slice(0, index);
        const buttonsEnd = this.props.buttons.slice(index + 1);

        this.props.setButtons(
            this.props.name,
            [...buttonsStart, ...buttonsEnd],
            this.props.removeButtons,
            this.props.activeIndex
        );
    };

    addSeparator = (event) => {
        const buttonsStart = this.props.buttons.slice(0, this.props.activeIndex);
        const buttonsEnd = this.props.buttons.slice(this.props.activeIndex);

        this.props.setButtons(
            this.props.name,
            [...buttonsStart, event.target.getAttribute('data-separator'), ...buttonsEnd],
            this.props.removeButtons,
            this.props.activeIndex
        );
    };
    setActive = (index) => {
        this.props.setButtons(
            this.props.name,
            this.props.buttons,
            this.props.removeButtons,
            index
        );
    };
    restoreDefaults = () => {
        if (window.confirm('Are you shure?')) {
            this.props.setButtons( this.props.name, Jodit.defaultOptions[this.props.name], [], 0);
        }
    };

    render() {
        const list = this.props.buttons.map((key, index) => {
            switch (key) {
                case "\n":
                    return <Break move={this.move} remove={this.remove} setActive={this.setActive} active={this.props.activeIndex === index} label={key} index={index} key={index}/>;
                case "|":
                    return <Separator move={this.move} remove={this.remove} setActive={this.setActive} active={this.props.activeIndex === index} label={key} index={index} key={index}/>;
                default:
                    return <Button move={this.move} checked={this.props.removeButtons.indexOf(key) === -1} toggle={this.toggle} setActive={this.setActive} active={this.props.activeIndex === index} label={key} index={index} key={index}/>
            }
        });

        return (
            <div>
                <table className={style.table}>
                    <tbody>
                    <tr>
                        <td colSpan={5} style={{textAlign: "right", padding: "5px 0"}}>
                            <span onClick={this.restoreDefaults} className={style.restore} title="Restore default"></span>
                            <span onClick={this.addSeparator} data-separator={"\n"} className={style.add} title="Add Break">Break</span>
                            <span onClick={this.addSeparator} data-separator="|" className={style.add} title="Add Separator">Separator</span>
                            <span onClick={this.toggleAll} className={style.restore} title="Toggle all">Toggle all</span>
                        </td>
                    </tr>
                    {list}
                    </tbody>

                </table>
                <p className={style.info}>Double-Click selected row</p>
            </div>
        );
    }
}