import React from "react";
import './style.css'
import SearchIcon from '@material-ui/icons/Search';
import DeleteIcon from '@material-ui/icons/Delete';
import IconButton from '@material-ui/core/IconButton';

export class Search extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            inputValue: "",
        };

        this.updateInputValue = this.updateInputValue.bind(this);
    }

    componentDidMount() {
        if (this.props.searchItem) {
            this.setState({
                inputValue: this.props.searchItem,
            });
        }
    }

    updateInputValue(event) {
        this.setState({
            inputValue: event.target.value,
        });
    }

    handleClickSearch = () => {
        alert("find")
    }

    handleClickDelete = () => {
        this.setState({
            inputValue: "",
        });
    };

    render() {
        return (
            <form
                className="search"
                onSubmit={(event) => {
                    event.preventDefault();
                    this.props.search(this.state.inputValue);
                }}
            >
                <input
                    type="text"
                    value={this.state.inputValue}
                    onChange={this.updateInputValue}
                    placeholder="Поиск"
                    className="searchArea"
                />
                <IconButton onClick={this.handleClickSearch}>
                    <SearchIcon />
                </IconButton>

                <IconButton onClick={this.handleClickDelete}>
                    <DeleteIcon />
                </IconButton>
            </form>
        );
    }
}