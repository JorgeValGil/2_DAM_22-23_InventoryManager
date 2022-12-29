package com.example.inventorymanager

import android.os.Bundle
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.appcompat.app.AppCompatActivity
import androidx.core.content.res.ResourcesCompat
import androidx.fragment.app.Fragment
import androidx.navigation.fragment.findNavController
import com.example.inventorymanager.databinding.FragmentMenuBinding

class MenuFragment : Fragment() {

    private var _binding: FragmentMenuBinding? = null

    private val binding get() = _binding!!

    override fun onCreateView(
        inflater: LayoutInflater,
        container: ViewGroup?,
        savedInstanceState: Bundle?
    ): View? {
        _binding = FragmentMenuBinding.inflate(inflater, container, false)
        return binding.root
    }

    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        val username = MenuFragmentArgs.fromBundle(requireArguments()).username
        val str: String = getString(R.string.welcome) + ' ' + username

        binding.textViewSecond.typeface =
            ResourcesCompat.getFont(binding.root.context, R.font.bluetea)

        binding.textViewSecond.text = str
        binding.buttonSecondToFirst.setOnClickListener {
            findNavController().navigate(
                MenuFragmentDirections.actionMenuFragmentToLoginFragment()
            )
        }
        binding.buttonGoToCategories.setOnClickListener {
            findNavController().navigate(
                MenuFragmentDirections.actionMenuFragmentToCategoriesFragment()
            )
        }
        binding.buttonGoToProducts.setOnClickListener {
            findNavController().navigate(
                MenuFragmentDirections.actionMenuFragmentToProductsFragment()
            )
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