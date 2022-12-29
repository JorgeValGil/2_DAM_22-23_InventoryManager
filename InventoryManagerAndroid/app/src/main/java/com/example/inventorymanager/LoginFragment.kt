package com.example.inventorymanager

import android.database.sqlite.SQLiteDatabase
import android.os.Bundle
import android.text.Spannable
import android.text.SpannableString
import android.text.style.ForegroundColorSpan
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.TextView
import androidx.appcompat.app.AppCompatActivity
import androidx.core.content.ContextCompat
import androidx.core.content.res.ResourcesCompat
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import com.example.inventorymanager.databinding.FragmentLoginBinding
import com.google.android.material.snackbar.Snackbar

class LoginFragment : Fragment() {
    private var _binding: FragmentLoginBinding? = null
    private lateinit var usersDB: DB
    private val binding get() = _binding!!

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        _binding = FragmentLoginBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)

        usersDB = DB(binding.root.context)

        val textViewAppName = view.findViewById<View>(R.id.app_name) as TextView
        textViewAppName.typeface = ResourcesCompat.getFont(binding.root.context, R.font.bluetea)
        val wordOne: Spannable = SpannableString(getString(R.string.app_name_inventory))
        val colorOne = ContextCompat.getColor(binding.root.context, R.color.im_orange)
        wordOne.setSpan(
            ForegroundColorSpan(colorOne),
            0,
            wordOne.length,
            Spannable.SPAN_EXCLUSIVE_EXCLUSIVE
        )

        textViewAppName.text = wordOne
        val wordTwo: Spannable = SpannableString(getString(R.string.app_name_manager))
        val colorTwo = ContextCompat.getColor(binding.root.context, R.color.im_red)
        wordTwo.setSpan(
            ForegroundColorSpan(colorTwo),
            0,
            wordTwo.length,
            Spannable.SPAN_EXCLUSIVE_EXCLUSIVE
        )
        textViewAppName.append(wordTwo)


        binding.login.setOnClickListener {
            val enteredEmail: String = binding.userEmail.text.toString()
            val enteredPassword: String = binding.userPassword.text.toString()

            val db: SQLiteDatabase = usersDB.readableDatabase
            val cursor = db.rawQuery(
                "select * from users where email = ? AND password = ?",
                arrayOf(enteredEmail, enteredPassword)
            )

            var isValid = false
            if (cursor.moveToFirst()) {
                do {
                    if (enteredEmail == cursor.getString(1) && enteredPassword == cursor.getString(2)) {
                        isValid = true
                    }
                } while (cursor.moveToNext())
            }
            cursor.close()

            if (isValid) {
                findNavController().navigate(
                    LoginFragmentDirections.actionLoginFragmentToMenuFragment(
                        enteredEmail
                    )
                )
            } else {
                Snackbar.make(binding.root, R.string.no_valid_user_data, Snackbar.LENGTH_SHORT)
                    .show()
            }
        }
    }

    override fun onDestroyView() {
        super.onDestroyView()
        _binding = null
    }

    override fun onResume() {
        super.onResume()
        (activity as AppCompatActivity?)!!.supportActionBar!!.hide()
    }

    override fun onStop() {
        super.onStop()
        (activity as AppCompatActivity?)!!.supportActionBar!!.show()
    }
}