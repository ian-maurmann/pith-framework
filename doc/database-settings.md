# Database setup notes

---

- database `MariaDB 10.7.3`
- characterset `utf8mb4`
- collation `utf8mb4_unicode_ci`

---

# Conventions

### Table names

Table names should be: 
- lowercase, 
- underscored, 
- plural for single word names,
- singular then plural for multi-word names,

Example:
```
users
groups
user_groups
```

Not:
```
user
User
Users
USERS
usergroup
user_group
usergroups
userGroups
UserGroups

```


Use underscore_names instead of CamelCase
Table names should be plural
Spell out id fields (item_id instead of id)


### PKs

Primary keys should be

- lowercase,
- separate words by underscores,
- singular
- named for the table
- should end in "id"
- In linker tables the word "to" can be used.
- Not named pk.

Example:
```
user_id
group_id
user_to_group_id
```

Not:
```
id
groups_id
pk
user_pk
```


### Fields

Column names should be:
- lowercase,
- separate words by underscores,
- Not have "id" in the name unless it's a pk or fk.
- No Hungarian notation.
- Avoid abbreviation.
- Tiny Int Boolean fields should start with "is" "can" "did" or "was".
- Sting "Yes" "No" fields can use "yn" at the end, but should normally be avoided in favor of Tiny Int Boolean fields.

Example:
```
name
first_name
is_ready
```

Not
```
firstName
FirstName
FIRSTNAME

str_name
intNumLS

ready
bool_ready
bool_is_ready

str_is_ready
is_ready_yes_no
```