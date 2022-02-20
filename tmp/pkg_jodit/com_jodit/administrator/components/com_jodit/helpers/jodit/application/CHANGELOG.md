# Changelog

> **Tags:**
>
> -   :boom: [Breaking Change]
> -   :rocket: [New Feature]
> -   :bug: [Bug Fix]
> -   :memo: [Documentation]
> -   :house: [Internal]
> -   :nail_care: [Polish]

## 3.0.1

#### :boom: Breaking Change

Change response for folders

There was:

```json
{
	"success": true,
	"data": {
		"sources": {
			"source1": {
				"folders": []
			},
			"source2": {
				"folders": []
			}
		}
	}
}
```

Now:

```json
{
	"success": true,
	"data": {
		"sources": [
			{
				"name": "source1",
				"folders": []
			},
			{
				"name": "source2",
				"folders": []
			}
		]
	}
}
```
